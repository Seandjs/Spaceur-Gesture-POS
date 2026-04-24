@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm font-medium text-neutral-500">Modul Admin</p>
            <h2 class="mt-1 text-2xl font-semibold tracking-tight text-neutral-900">Data Barang</h2>
            <p class="mt-2 text-sm leading-6 text-neutral-600">
                Halaman untuk melihat daftar produk yang telah didaftarkan.
            </p>
        </div>

        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center rounded-xl bg-neutral-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-neutral-800">
            Tambah Barang
        </a>
    </div>

    <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
        <div class="mb-4">
            <input type="text" placeholder="Cari produk..."
                class="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 outline-none focus:border-neutral-900 md:max-w-sm">
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-neutral-200 text-neutral-500">
                        <th class="px-3 py-3 font-medium">Kode</th>
                        <th class="px-3 py-3 font-medium">Nama</th>
                        <th class="px-3 py-3 font-medium">Kategori</th>
                        <th class="px-3 py-3 font-medium">Ukuran</th>
                        <th class="px-3 py-3 font-medium">Harga</th>
                        <th class="px-3 py-3 font-medium">Barcode</th>
                        <th class="px-3 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-neutral-800">
                    <tr class="border-b border-neutral-100">
                        <td class="px-3 py-4">SPCR-001</td>
                        <td class="px-3 py-4">Kaos Hitam</td>
                        <td class="px-3 py-4">Kaos</td>
                        <td class="px-3 py-4">M</td>
                        <td class="px-3 py-4">85.000</td>
                        <td class="px-3 py-4">barcode_001.png</td>
                        <td class="px-3 py-4">
                            <div class="flex gap-2">
                                <button class="rounded-lg border border-neutral-300 px-3 py-2 text-xs font-medium text-neutral-700 hover:bg-neutral-100">
                                    Edit
                                </button>
                                <button class="rounded-lg border border-neutral-300 px-3 py-2 text-xs font-medium text-neutral-700 hover:bg-neutral-100">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-3 py-4">SPCR-002</td>
                        <td class="px-3 py-4">Kemeja Putih</td>
                        <td class="px-3 py-4">Kemeja</td>
                        <td class="px-3 py-4">L</td>
                        <td class="px-3 py-4">120.000</td>
                        <td class="px-3 py-4">barcode_002.png</td>
                        <td class="px-3 py-4">
                            <div class="flex gap-2">
                                <button class="rounded-lg border border-neutral-300 px-3 py-2 text-xs font-medium text-neutral-700 hover:bg-neutral-100">
                                    Edit
                                </button>
                                <button class="rounded-lg border border-neutral-300 px-3 py-2 text-xs font-medium text-neutral-700 hover:bg-neutral-100">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection