@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <section class="rounded-3xl border border-neutral-200 bg-white p-8 shadow-sm">
        <p class="text-xs font-medium uppercase tracking-[0.25em] text-neutral-500">Project System</p>
        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-neutral-900 md:text-4xl">
            Sistem Kasir Pakaian Berbasis Gesture Tangan
        </h2>
        <p class="mt-4 max-w-3xl text-sm leading-6 text-neutral-600 md:text-base">
            Sistem ini terdiri dari modul kasir dan modul admin. Modul kasir digunakan untuk transaksi
            penjualan dengan login gesture tangan, sedangkan modul admin digunakan untuk pendataan produk
            dan pembuatan barcode.
        </p>
    </section>

    <section class="grid gap-6 md:grid-cols-2">
        <a href="{{ route('cashier.gesture-login') }}"
           class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm transition hover:border-neutral-300 hover:shadow-md">
            <p class="text-sm font-medium text-neutral-500">Modul 01</p>
            <h3 class="mt-2 text-2xl font-semibold tracking-tight text-neutral-900">Kasir</h3>
            <p class="mt-3 text-sm leading-6 text-neutral-600">
                Login gesture, pemindaian barcode, keranjang belanja, total transaksi, dan cetak struk.
            </p>
            <div class="mt-6 inline-flex items-center rounded-xl border border-neutral-900 px-4 py-2 text-sm font-medium text-neutral-900">
                Buka Modul
            </div>
        </a>

        <a href="{{ route('admin.products.index') }}"
           class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm transition hover:border-neutral-300 hover:shadow-md">
            <p class="text-sm font-medium text-neutral-500">Modul 02</p>
            <h3 class="mt-2 text-2xl font-semibold tracking-tight text-neutral-900">Admin Produk</h3>
            <p class="mt-3 text-sm leading-6 text-neutral-600">
                Pendataan barang, generate kode produk otomatis, dan generate barcode untuk kebutuhan kasir.
            </p>
            <div class="mt-6 inline-flex items-center rounded-xl border border-neutral-900 px-4 py-2 text-sm font-medium text-neutral-900">
                Buka Modul
            </div>
        </a>
    </section>
</div>
@endsection