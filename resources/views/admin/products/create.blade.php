@extends('layouts.app')

@section('content')
<div class="grid gap-6 lg:grid-cols-[1fr_0.8fr]">
    <section class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <p class="text-sm font-medium text-neutral-500">Modul Admin</p>
            <h2 class="mt-1 text-2xl font-semibold tracking-tight text-neutral-900">Tambah Data Barang</h2>
            <p class="mt-2 text-sm leading-6 text-neutral-600">
                Isi data barang. Kode produk dan barcode akan dibuat otomatis setelah data berhasil disimpan.
            </p>
        </div>

        <form class="space-y-5">
            <div>
                <label class="mb-2 block text-sm font-medium text-neutral-700">Nama Barang</label>
                <input type="text" placeholder="Contoh: Kaos Hitam"
                    class="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 outline-none focus:border-neutral-900">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-neutral-700">Kategori</label>
                <select class="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 outline-none focus:border-neutral-900">
                    <option>Pilih kategori</option>
                    <option>Kaos</option>
                    <option>Kemeja</option>
                    <option>Hoodie</option>
                    <option>Jaket</option>
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-neutral-700">Ukuran</label>
                <select class="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 outline-none focus:border-neutral-900">
                    <option>Pilih ukuran</option>
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                    <option>XL</option>
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-neutral-700">Harga</label>
                <input type="number" placeholder="Contoh: 85000"
                    class="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 outline-none focus:border-neutral-900">
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="button"
                    class="rounded-xl bg-neutral-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-neutral-800">
                    Simpan Barang
                </button>

                <a href="{{ route('admin.products.index') }}"
                   class="rounded-xl border border-neutral-300 bg-white px-5 py-3 text-sm font-medium text-neutral-800 transition hover:bg-neutral-100">
                    Kembali
                </a>
            </div>
        </form>
    </section>

    <aside class="space-y-6">
        <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold tracking-tight text-neutral-900">Preview</h3>

            <div class="mt-4 space-y-3 text-sm">
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50 p-4">
                    <p class="text-neutral-500">Kode Produk</p>
                    <p class="mt-1 text-base font-semibold text-neutral-900">SPCR-001</p>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-neutral-50 p-4">
                    <p class="text-neutral-500">Barcode</p>
                    <div class="mt-3 flex h-24 items-center justify-center rounded-xl border border-dashed border-neutral-300 bg-white text-sm text-neutral-400">
                        Preview barcode
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold tracking-tight text-neutral-900">Aturan Data</h3>
            <ul class="mt-4 space-y-2 text-sm leading-6 text-neutral-600">
                <li>- Satu ukuran dihitung sebagai satu data produk.</li>
                <li>- Kode produk dibuat otomatis oleh sistem.</li>
                <li>- Barcode dibuat setelah data barang tersimpan.</li>
            </ul>
        </div>
    </aside>
</div>
@endsection