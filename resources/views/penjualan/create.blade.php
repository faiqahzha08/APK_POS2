@extends('layouts.app')

@section('title', 'Transaksi Baru - POS')

@section('content')
    <div class="mb-8">
        <a href="{{ route('penjualan.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-indigo-600 transition mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Transaksi Baru</h1>
        <p class="mt-1 text-sm text-slate-500">Tambah produk ke keranjang penjualan</p>
    </div>

    <form action="{{ route('penjualan.store') }}" method="POST" id="form-penjualan">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Pilih Produk -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                    <h3 class="font-semibold text-slate-800 mb-4">Pilih Produk</h3>

                    <div id="items-container" class="space-y-3">
                        <div class="item-row flex flex-col sm:flex-row gap-3 items-start sm:items-end">
                            <div class="flex-1 w-full">
                                <label class="block text-xs text-slate-500 mb-1">Produk</label>
                                <select name="produk_id[]" required
                                        class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none text-sm bg-white produk-select">
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($produks as $p)
                                        <option value="{{ $p->id }}" data-harga="{{ $p->harga }}" data-stok="{{ $p->stok }}">
                                            {{ $p->nama }} (Stok: {{ $p->stok }}) - Rp {{ number_format($p->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-28">
                                <label class="block text-xs text-slate-500 mb-1">Qty</label>
                                <input type="number" name="qty[]" value="1" min="1" required
                                       class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none text-sm qty-input">
                            </div>
                            <button type="button" class="remove-row p-2.5 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition hidden">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <button type="button" id="add-item"
                            class="mt-4 inline-flex items-center gap-1.5 text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Tambah Item
                    </button>
                </div>
            </div>

            <!-- Ringkasan -->
            <div>
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sticky top-24">
                    <h3 class="font-semibold text-slate-800 mb-4">Ringkasan</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between text-slate-600">
                            <span>Total Item</span>
                            <span id="total-item">0</span>
                        </div>
                        <div class="border-t border-slate-100 pt-3 flex justify-between">
                            <span class="font-semibold text-slate-800">Total Bayar</span>
                            <span class="font-bold text-indigo-600 text-lg" id="total-bayar">Rp 0</span>
                        </div>
                    </div>
                    <button type="submit"
                            class="mt-5 w-full px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition shadow-sm shadow-indigo-200">
                        Simpan Transaksi
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    lucide.createIcons();

    const container = document.getElementById('items-container');
    const addBtn = document.getElementById('add-item');

    function updateTotal() {
        let total = 0;
        let itemCount = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const select = row.querySelector('.produk-select');
            const qty = parseInt(row.querySelector('.qty-input').value) || 0;
            const option = select.options[select.selectedIndex];
            if (option && option.dataset.harga) {
                total += parseFloat(option.dataset.harga) * qty;
                itemCount += qty;
            }
        });
        document.getElementById('total-bayar').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('total-item').textContent = itemCount;
    }

    container.addEventListener('change', updateTotal);
    container.addEventListener('input', updateTotal);

    addBtn.addEventListener('click', () => {
        const firstRow = container.querySelector('.item-row');
        const clone = firstRow.cloneNode(true);
        clone.querySelector('.produk-select').value = '';
        clone.querySelector('.qty-input').value = 1;
        clone.querySelector('.remove-row').classList.remove('hidden');
        container.appendChild(clone);
        lucide.createIcons();
        updateTotal();
    });

    container.addEventListener('click', (e) => {
        if (e.target.closest('.remove-row')) {
            const rows = container.querySelectorAll('.item-row');
            if (rows.length > 1) {
                e.target.closest('.item-row').remove();
                updateTotal();
            }
        }
    });
</script>
@endpush