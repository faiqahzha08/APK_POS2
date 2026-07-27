@extends('layouts.app')

@section('title', 'Detail Transaksi - POS')

@section('content')
    <div class="mb-8">
        <a href="{{ route('penjualan.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-indigo-600 transition mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Detail Transaksi</h1>
        <p class="mt-1 text-sm text-slate-500">{{ $penjualan->kode ?? '#'.$penjualan->id }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h3 class="font-semibold text-slate-800">Item Transaksi</h3>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="text-left px-5 py-3 font-semibold text-slate-600">Produk</th>
                            <th class="text-center px-5 py-3 font-semibold text-slate-600">Qty</th>
                            <th class="text-right px-5 py-3 font-semibold text-slate-600">Harga</th>
                            <th class="text-right px-5 py-3 font-semibold text-slate-600">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($penjualan->details as $detail)
                        <tr>
                            <td class="px-5 py-3 font-medium text-slate-800">{{ $detail->produk->nama ?? '-' }}</td>
                            <td class="px-5 py-3 text-center text-slate-600">{{ $detail->qty }}</td>
                            <td class="px-5 py-3 text-right text-slate-600">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td class="px-5 py-3 text-right font-medium text-slate-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <h3 class="font-semibold text-slate-800 mb-4">Informasi</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">No. Transaksi</span>
                        <span class="font-medium text-slate-800">{{ $penjualan->kode ?? '#'.$penjualan->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Tanggal</span>
                        <span class="font-medium text-slate-800">{{ $penjualan->created_at?->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Kasir</span>
                        <span class="font-medium text-slate-800">{{ $penjualan->user->name ?? '-' }}</span>
                    </div>
                    <div class="border-t border-slate-100 pt-3 flex justify-between">
                        <span class="font-semibold text-slate-800">Total</span>
                        <span class="font-bold text-indigo-600 text-lg">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection