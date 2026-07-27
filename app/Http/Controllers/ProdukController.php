<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->stok === 'aman') {
            $query->where('stok', '>=', 10);
        } elseif ($request->stok === 'rendah') {
            $query->where('stok', '>', 0)->where('stok', '<', 10);
        } elseif ($request->stok === 'habis') {
            $query->where('stok', '<=', 0);
        }

        $produks = $query->latest()->paginate(10)->withQueryString();

        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok'  => 'required|integer|min:0',
            'kode'  => 'nullable|string|max:50',
        ]);

        Produk::create($request->only('nama', 'harga', 'stok', 'kode'));

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama'  => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok'  => 'required|integer|min:0',
            'kode'  => 'nullable|string|max:50',
        ]);

        $produk->update($request->only('nama', 'harga', 'stok', 'kode'));

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }
}