@extends('layouts.app')

@section('title', 'Produk - POS')

@section('content')
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Daftar Produk</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola semua produk yang tersedia di toko</p>
        </div>
        <a href="{{ route('produk.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition shadow-sm shadow-indigo-200">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Produk
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('produk.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama produk..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none text-sm transition">
            </div>
            <select name="stok" class="px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none text-sm bg-white">
                <option value="">Semua Stok</option>
                <option value="aman" {{ request('stok') == 'aman' ? 'selected' : '' }}>Stok Aman</option>
                <option value="rendah" {{ request('stok') == 'rendah' ? 'selected' : '' }}>Stok Rendah</option>
                <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>Stok Habis</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-xl transition">
                Filter
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-left px-6 py-3.5 font-semibold text-slate-600 w-12">#</th>
                        <th class="text-left px-6 py-3.5 font-semibold text-slate-600">Nama Produk</th>
                        <th class="text-left px-6 py-3.5 font-semibold text-slate-600">Harga</th>
                        <th class="text-center px-6 py-3.5 font-semibold text-slate-600">Stok</th>
                        <th class="text-right px-6 py-3.5 font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($produks ?? [] as $index => $produk)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="px-6 py-4 text-slate-500">{{ $produks->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-800">{{ $produk->nama }}</div>
                            @if(!empty($produk->kode))
                                <div class="text-xs text-slate-400 mt-0.5">{{ $produk->kode }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-700">
                            Rp {{ number_format($produk->harga ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php $stok = $produk->stok ?? 0; @endphp
                            @if($stok <= 0)
                                <span class="inline-flex px-2.5 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-semibold">Habis</span>
                            @elseif($stok < 10)
                                <span class="inline-flex px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">{{ $stok }}</span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">{{ $stok }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('produk.edit', $produk->id) }}"
                                   class="p-2 rounded-lg text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition" title="Edit">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?')">
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
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                    <i data-lucide="package" class="w-7 h-7 text-slate-400"></i>
                                </div>
                                <p class="text-sm font-medium text-slate-600">Belum ada produk</p>
                                <p class="text-xs text-slate-400 mt-1">Mulai dengan menambahkan produk baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($produks) && method_exists($produks, 'links'))
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $produks->links() }}
            </div>
        @endif
    </div>
@endsection