@extends('layouts.app')

@section('content')
<div class="grid gap-6 lg:grid-cols-[1fr_0.8fr]">
    <section class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <p class="text-sm font-medium text-neutral-500">Modul Admin</p>
            <h2 class="mt-1 text-2xl font-semibold tracking-tight text-neutral-900">Edit Data Barang</h2>
            <p class="mt-2 text-sm leading-6 text-neutral-600">
                Ubah data barang sesuai kebutuhan. Kode produk tetap menggunakan kode yang sudah ada.
            </p>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-2 block text-sm font-medium text-neutral-700">Nama Barang</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                    class="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 outline-none focus:border-neutral-900">
                @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-neutral-700">Kategori</label>
                <select name="category"
                    class="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 outline-none focus:border-neutral-900">
                    <option value="">Pilih kategori</option>
                    <option value="Kaos" {{ old('category', $product->category) == 'Kaos' ? 'selected' : '' }}>Kaos</option>
                    <option value="Kemeja" {{ old('category', $product->category) == 'Kemeja' ? 'selected' : '' }}>Kemeja</option>
                    <option value="Hoodie" {{ old('category', $product->category) == 'Hoodie' ? 'selected' : '' }}>Hoodie</option>
                    <option value="Jaket" {{ old('category', $product->category) == 'Jaket' ? 'selected' : '' }}>Jaket</option>
                </select>
                @error('category')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-neutral-700">Ukuran</label>
                <select name="size"
                    class="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 outline-none focus:border-neutral-900">
                    <option value="">Pilih ukuran</option>
                    <option value="S" {{ old('size', $product->size) == 'S' ? 'selected' : '' }}>S</option>
                    <option value="M" {{ old('size', $product->size) == 'M' ? 'selected' : '' }}>M</option>
                    <option value="L" {{ old('size', $product->size) == 'L' ? 'selected' : '' }}>L</option>
                    <option value="XL" {{ old('size', $product->size) == 'XL' ? 'selected' : '' }}>XL</option>
                </select>
                @error('size')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-neutral-700">Harga</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}"
                    class="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 outline-none focus:border-neutral-900">
                @error('price')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit"
                    class="rounded-xl bg-neutral-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-neutral-800">
                    Update Barang
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
            <h3 class="text-lg font-semibold tracking-tight text-neutral-900">Informasi Produk</h3>

            <div class="mt-4 space-y-3 text-sm">
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50 p-4">
                    <p class="text-neutral-500">Kode Produk</p>
                    <p class="mt-1 text-base font-semibold text-neutral-900">{{ $product->code }}</p>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-neutral-50 p-4">
                    <p class="text-neutral-500">Barcode</p>

                    @if ($product->barcode_path)
                    <div class="mt-3 rounded-xl border border-neutral-200 bg-white p-3">
                        <img src="{{ asset('storage/' . $product->barcode_path) }}"
                            alt="Barcode {{ $product->code }}"
                            class="h-auto w-full object-contain">
                    </div>
                    @else
                    <p class="mt-1 text-neutral-900">Belum tersedia</p>
                    @endif
                </div>
            </div>
        </div>
    </aside>
</div>
@endsection