<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\PenjualanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with('user')->latest()->paginate(10);

        $totalTransaksi = Penjualan::count();
        $totalOmzet = Penjualan::sum('total_pembayaran');
        $hariIni        = Penjualan::whereDate('created_at', today())->count();

        return view('penjualan.index', compact('penjualans', 'totalTransaksi', 'totalOmzet', 'hariIni'));
    }

    public function create()
    {
        $produks = Produk::where('stok', '>', 0)->orderBy('nama')->get();
        return view('penjualan.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id'   => 'required|array',
            'produk_id.*' => 'exists:produks,id',
            'qty'         => 'required|array',
            'qty.*'       => 'integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            $items = [];

            foreach ($request->produk_id as $i => $produkId) {
                $produk = Produk::findOrFail($produkId);
                $qty    = $request->qty[$i];

                if ($produk->stok < $qty) {
                    throw new \Exception("Stok {$produk->nama} tidak cukup");
                }

                $subtotal = $produk->harga * $qty;
                $total   += $subtotal;

                $items[] = [
                    'produk'   => $produk,
                    'qty'      => $qty,
                    'harga'    => $produk->harga,
                    'subtotal' => $subtotal,
                ];
            }

            $penjualan = Penjualan::create([
    'user_id'           => auth()->id(),
    'total_pembayaran'  => $total,
    'metode_pembayaran' => 'cash',
    'status'            => 'COMPLETED',
]);
            foreach ($items as $item) {
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'produk_id'    => $item['produk']->id,
                    'qty'          => $item['qty'],
                    'harga'        => $item['harga'],
                    'subtotal'     => $item['subtotal'],
                ]);

                $item['produk']->decrement('stok', $item['qty']);
            }

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['user', 'itemPenjualan.produk'])->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::with('itemPenjualan')->findOrFail($id);

        DB::beginTransaction();
        try {
            foreach ($penjualan->itemPenjualan as $detail) {
                Produk::where('id', $detail->produk_id)->increment('stok', $detail->qty);
            }
            $penjualan->details()->delete();
            $penjualan->delete();

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi');
        }
    }
}