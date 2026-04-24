@extends('layouts.app')

@section('content')
<div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
    <section class="space-y-6">
        <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-500">Modul Kasir</p>
                    <h2 class="mt-1 text-2xl font-semibold tracking-tight text-neutral-900">Point of Sale</h2>
                </div>

                <div class="grid gap-3 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700">Kode Barcode</label>
                        <input type="text" placeholder="SPCR-001"
                            class="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 outline-none focus:border-neutral-900">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700">Jumlah</label>
                        <input type="number" min="1" value="1"
                            class="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 outline-none focus:border-neutral-900">
                    </div>
                </div>
            </div>

            <div class="mt-5 flex gap-3">
                <button type="button"
                    class="rounded-xl bg-neutral-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-neutral-800">
                    Tambah ke Keranjang
                </button>

                <button type="button"
                    class="rounded-xl border border-neutral-300 bg-white px-5 py-3 text-sm font-medium text-neutral-800 transition hover:bg-neutral-100">
                    Reset
                </button>
            </div>
        </div>

        <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold tracking-tight text-neutral-900">Keranjang Belanja</h3>
                <span class="rounded-full border border-neutral-300 px-3 py-1 text-sm text-neutral-700">
                    2 item
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
                        </tr>
                    </thead>
                    <tbody class="text-neutral-800">
                        <tr class="border-b border-neutral-100">
                            <td class="px-3 py-4">SPCR-001</td>
                            <td class="px-3 py-4">Kaos Hitam - M</td>
                            <td class="px-3 py-4">2</td>
                            <td class="px-3 py-4">85.000</td>
                            <td class="px-3 py-4">170.000</td>
                        </tr>
                        <tr>
                            <td class="px-3 py-4">SPCR-002</td>
                            <td class="px-3 py-4">Kemeja Putih - L</td>
                            <td class="px-3 py-4">1</td>
                            <td class="px-3 py-4">120.000</td>
                            <td class="px-3 py-4">120.000</td>
                        </tr>
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
                    <span class="font-medium text-neutral-900">3</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-neutral-500">Subtotal</span>
                    <span class="font-medium text-neutral-900">290.000</span>
                </div>
                <div class="flex items-center justify-between border-t border-neutral-200 pt-4">
                    <span class="text-base font-semibold text-neutral-900">Total</span>
                    <span class="text-xl font-semibold text-neutral-900">290.000</span>
                </div>
            </div>

            <div class="mt-6 space-y-3">
                <button type="button"
                    class="w-full rounded-xl bg-neutral-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-neutral-800">
                    Konfirmasi Pembayaran
                </button>

                <button type="button"
                    class="w-full rounded-xl border border-neutral-300 bg-white px-5 py-3 text-sm font-medium text-neutral-800 transition hover:bg-neutral-100">
                    Cetak Struk
                </button>
            </div>
        </div>

        <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold tracking-tight text-neutral-900">Informasi</h3>
            <p class="mt-3 text-sm leading-6 text-neutral-600">
                Halaman ini nanti dihubungkan ke barcode scanner, transaksi Laravel, dan helper Python untuk printing.
            </p>
        </div>
    </aside>
</div>
@endsection