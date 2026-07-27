@extends('layouts.app')

@section('title', 'Penjualan - POS')

@section('content')
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Data Penjualan</h1>
            <p class="mt-1 text-sm text-slate-500">Riwayat transaksi penjualan</p>
        </div>
        <a href="{{ route('penjualan.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition shadow-sm shadow-indigo-200">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Transaksi Baru
        </a>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 card-hover">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-indigo-100 flex items-center justify-center">
                    <i data-lucide="shopping-cart" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Transaksi</p>
                    <p class="text-xl font-bold text-slate-900">{{ $totalTransaksi ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 card-hover">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <i data-lucide="banknote" class="w-5 h-5 text-emerald-600"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Omzet</p>
                    <p class="text-xl font-bold text-slate-900">Rp {{ number_format($totalOmzet ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 card-hover">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center">
                    <i data-lucide="calendar-days" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Hari Ini</p>
                    <p class="text-xl font-bold text-slate-900">{{ $hariIni ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-left px-6 py-3.5 font-semibold text-slate-600 w-12">#</th>
                        <th class="text-left px-6 py-3.5 font-semibold text-slate-600">No. Transaksi</th>
                        <th class="text-left px-6 py-3.5 font-semibold text-slate-600">Tanggal</th>
                        <th class="text-left px-6 py-3.5 font-semibold text-slate-600">Kasir</th>
                        <th class="text-right px-6 py-3.5 font-semibold text-slate-600">Total</th>
                        <th class="text-right px-6 py-3.5 font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($penjualans ?? [] as $index => $penjualan)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="px-6 py-4 text-slate-500">{{ $penjualans->firstItem() + $index }}</td>
                        <td class="px-6 py-4 font-medium text-slate-800">
                            {{ $penjualan->kode ?? '#'.$penjualan->id }}
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $penjualan->created_at?->format('d M Y H:i') ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $penjualan->user->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-slate-800">
                            Rp {{ number_format($penjualan->total ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('penjualan.show', $penjualan->id) }}"
                                   class="p-2 rounded-lg text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition" title="Detail">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('penjualan.destroy', $penjualan->id) }}" method="POST" onsubmit="return confirm('Yakin hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                    <i data-lucide="receipt" class="w-7 h-7 text-slate-400"></i>
                                </div>
                                <p class="text-sm font-medium text-slate-600">Belum ada transaksi</p>
                                <p class="text-xs text-slate-400 mt-1">Buat transaksi penjualan pertama</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($penjualans) && method_exists($penjualans, 'links'))
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $penjualans->links() }}
            </div>
        @endif
    </div>
@endsection