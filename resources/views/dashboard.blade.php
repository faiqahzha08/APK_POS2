@extends('layouts.app')

@section('title', 'Dashboard - POS')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                    Ringkasan Hari Ini
                </h1>
                <p class="mt-1.5 text-slate-500 flex items-center gap-2 text-sm">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                    {{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div class="flex items-center gap-2 text-xs font-medium text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-100">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Sistem Aktif
            </div>
        </div>
    </div>

    <!-- Critical Inventory Status -->
    <section class="mb-10">
        <div class="flex items-center gap-2 mb-5">
            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-600"></i>
            </div>
            <h2 class="text-lg font-semibold text-slate-900">Critical Inventory Status</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Stok Rendah -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden card-hover">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-white flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                            <i data-lucide="package-minus" class="w-4 h-4 text-amber-600"></i>
                        </div>
                        <h3 class="font-semibold text-slate-800">Daftar Produk Stok Rendah</h3>
                    </div>
                    <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-amber-100 text-amber-700">
                        {{ isset($stokRendah) ? $stokRendah->count() : 0 }} item
                    </span>
                </div>
                <div class="p-0">
                    @if(isset($stokRendah) && $stokRendah->count() > 0)
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th class="text-left px-5 py-3 font-semibold text-slate-600 w-12">#</th>
                                    <th class="text-left px-5 py-3 font-semibold text-slate-600">Nama</th>
                                    <th class="text-right px-5 py-3 font-semibold text-slate-600">Stok</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($stokRendah as $index => $produk)
                                <tr class="hover:bg-amber-50/40 transition">
                                    <td class="px-5 py-3 text-slate-500">{{ $index + 1 }}</td>
                                    <td class="px-5 py-3 font-medium text-slate-800">{{ $produk->nama }}</td>
                                    <td class="px-5 py-3 text-right">
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
                                            {{ $produk->stok }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex flex-col items-center justify-center py-10 text-center px-6">
                            <div class="w-14 h-14 rounded-full bg-emerald-50 flex items-center justify-center mb-3">
                                <i data-lucide="check-circle-2" class="w-7 h-7 text-emerald-500"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-700">Seluruh produk berada dalam kondisi stok aman</p>
                            <p class="text-xs text-slate-400 mt-1">Tidak ada produk dengan stok rendah</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Stok Habis -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden card-hover">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-rose-50 to-white flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-rose-100 flex items-center justify-center">
                            <i data-lucide="package-x" class="w-4 h-4 text-rose-600"></i>
                        </div>
                        <h3 class="font-semibold text-slate-800">Daftar Produk Habis</h3>
                    </div>
                    <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-rose-100 text-rose-700">
                        {{ isset($stokHabis) ? $stokHabis->count() : 0 }} item
                    </span>
                </div>
                <div class="p-0">
                    @if(isset($stokHabis) && $stokHabis->count() > 0)
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th class="text-left px-5 py-3 font-semibold text-slate-600 w-12">#</th>
                                    <th class="text-left px-5 py-3 font-semibold text-slate-600">Nama</th>
                                    <th class="text-right px-5 py-3 font-semibold text-slate-600">Stok</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($stokHabis as $index => $produk)
                                <tr class="hover:bg-rose-50/40 transition">
                                    <td class="px-5 py-3 text-slate-500">{{ $index + 1 }}</td>
                                    <td class="px-5 py-3 font-medium text-slate-800">{{ $produk->nama }}</td>
                                    <td class="px-5 py-3 text-right">
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-semibold">
                                            {{ $produk->stok }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex flex-col items-center justify-center py-10 text-center px-6">
                            <div class="w-14 h-14 rounded-full bg-emerald-50 flex items-center justify-center mb-3">
                                <i data-lucide="check-circle-2" class="w-7 h-7 text-emerald-500"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-700">Seluruh produk berada dalam kondisi stok aman</p>
                            <p class="text-xs text-slate-400 mt-1">Tidak ada produk yang habis</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Best Seller Products -->
    <section>
        <div class="flex items-center gap-2 mb-5">
            <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center">
                <i data-lucide="trophy" class="w-4 h-4 text-indigo-600"></i>
            </div>
            <h2 class="text-lg font-semibold text-slate-900">Best Seller Products</h2>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="text-left px-6 py-3.5 font-semibold text-slate-600 w-12">#</th>
                            <th class="text-left px-6 py-3.5 font-semibold text-slate-600">Nama Produk</th>
                            <th class="text-right px-6 py-3.5 font-semibold text-slate-600">Stok</th>
                            <th class="text-right px-6 py-3.5 font-semibold text-slate-600">Unit Terjual</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($bestSellers ?? [] as $index => $item)
                        <tr class="hover:bg-indigo-50/50 transition">
                            <td class="px-6 py-4">
                                @if($index === 0)
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">1</span>
                                @elseif($index === 1)
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-200 text-slate-600 text-xs font-bold">2</span>
                                @elseif($index === 2)
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">3</span>
                                @else
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 text-slate-500 text-xs font-bold">{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $item->nama }}</td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-medium">
                                    <i data-lucide="box" class="w-3 h-3"></i> {{ $item->stok }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">
                                    <i data-lucide="trending-up" class="w-3 h-3"></i> {{ $item->unit_terjual ?? $item->total_terjual ?? 0 }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm">
                                Belum ada data best seller
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection