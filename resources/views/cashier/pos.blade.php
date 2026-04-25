@extends('layouts.app')

@section('content')
<div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">

    <section class="space-y-6">
        @if (session('success'))
        <div class="rounded-2xl border border-neutral-200 bg-white p-4 text-sm text-neutral-700 shadow-sm">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="rounded-2xl border border-red-200 bg-white p-4 text-sm text-red-600 shadow-sm">
            {{ session('error') }}
        </div>
        @endif

        <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-500">Modul Kasir</p>
                    <h2 class="mt-1 text-2xl font-semibold tracking-tight text-neutral-900">Point of Sale</h2>
                </div>
            </div>

            <form action="{{ route('cashier.add-to-cart') }}" method="POST" class="mt-5">
                @csrf

                <div class="grid gap-3 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700">Kode Barcode</label>
                        <input type="text" name="code" value="{{ old('code') }}" placeholder="SPCR-001"
                            class="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 outline-none focus:border-neutral-900">
                        @error('code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700">Jumlah</label>
                        <input type="number" name="qty" min="1" value="{{ old('qty', 1) }}"
                            class="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 outline-none focus:border-neutral-900">
                        @error('qty')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-5 flex gap-3">
                    <button type="submit"
                        class="rounded-xl bg-neutral-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-neutral-800">
                        Tambah ke Keranjang
                    </button>

                    <a href="{{ route('cashier.pos') }}"
                        class="rounded-xl border border-neutral-300 bg-white px-5 py-3 text-sm font-medium text-neutral-800 transition hover:bg-neutral-100">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold tracking-tight text-neutral-900">Keranjang Belanja</h3>
                <span class="rounded-full border border-neutral-300 px-3 py-1 text-sm text-neutral-700">
                    {{ $totalItems }} item
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-neutral-200 text-neutral-500">
                            <th class="px-3 py-3 font-medium">Kode</th>
                            <th class="px-3 py-3 font-medium">Produk</th>
                            <th class="px-3 py-3 font-medium">Qty</th>
                            <th class="px-3 py-3 font-medium">Harga</th>
                            <th class="px-3 py-3 font-medium">Subtotal</th>
                            <th class="px-3 py-3 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-neutral-800">
                        @forelse ($cart as $item)
                        <tr class="border-b border-neutral-100">
                            <td class="px-3 py-4">{{ $item['code'] }}</td>
                            <td class="px-3 py-4">{{ $item['name'] }} - {{ $item['size'] }}</td>
                            <td class="px-3 py-4">{{ $item['qty'] }}</td>
                            <td class="px-3 py-4">{{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="px-3 py-4">{{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                            <td class="px-3 py-4">
                                <form action="{{ route('cashier.remove-from-cart') }}" method="POST"
                                    onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                    <button type="submit"
                                        class="rounded-lg border border-neutral-300 px-3 py-2 text-xs font-medium text-neutral-700 hover:bg-neutral-100">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-3 py-6 text-center text-sm text-neutral-500">
                                Keranjang masih kosong.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <aside class="space-y-6">
        <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold tracking-tight text-neutral-900">Ringkasan Transaksi</h3>

            <div class="mt-4 space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-neutral-500">Jumlah Item</span>
                    <span class="font-medium text-neutral-900">{{ $totalItems }}</span>
                </div>
                <div class="flex items-center justify-between border-t border-neutral-200 pt-4">
                    <span class="text-base font-semibold text-neutral-900">Total</span>
                    <span class="text-xl font-semibold text-neutral-900">{{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-6 space-y-3">
                <form action="{{ route('cashier.checkout') }}" method="POST"
                    onsubmit="return confirm('Konfirmasi pembayaran dan simpan transaksi?')">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-xl bg-neutral-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-neutral-800">
                        Konfirmasi Pembayaran
                    </button>
                </form>

                <form action="{{ route('cashier.clear-cart') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-xl border border-neutral-300 bg-white px-5 py-3 text-sm font-medium text-neutral-800 transition hover:bg-neutral-100">
                        Kosongkan Keranjang
                    </button>
                </form>
                <a href="{{ route('cashier.sales-history') }}"
                    class="block w-full rounded-xl border border-neutral-300 bg-white px-5 py-3 text-center text-sm font-medium text-neutral-800 transition hover:bg-neutral-100">
                    Lihat Riwayat Transaksi
                </a>
            </div>
        </div>

        <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold tracking-tight text-neutral-900">Informasi</h3>
            <p class="mt-3 text-sm leading-6 text-neutral-600">
                Saat ini input barcode masih manual. Nanti tinggal diarahkan ke barcode scanner.
            </p>
        </div>
    </aside>
</div>
@endsection