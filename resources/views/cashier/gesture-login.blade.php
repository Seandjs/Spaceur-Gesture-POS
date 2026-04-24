@extends('layouts.app')

@section('content')
<div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
    <section class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
        <div class="mb-5">
            <p class="text-sm font-medium text-neutral-500">Modul Kasir</p>
            <h2 class="mt-1 text-2xl font-semibold tracking-tight text-neutral-900">Login Gesture Tangan</h2>
            <p class="mt-2 text-sm leading-6 text-neutral-600">
                Halaman ini akan digunakan untuk membaca gesture tangan melalui webcam sebelum kasir
                masuk ke halaman transaksi.
            </p>
        </div>

        <div class="overflow-hidden rounded-2xl border border-dashed border-neutral-300 bg-neutral-100">
            <div class="flex aspect-video items-center justify-center text-sm text-neutral-400">
                Area webcam / preview gesture
            </div>
        </div>

        <div class="mt-5 flex flex-wrap gap-3">
            <button type="button"
                class="rounded-xl bg-neutral-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-neutral-800">
                Mulai Kamera
            </button>

            <button type="button"
                class="rounded-xl border border-neutral-300 bg-white px-5 py-3 text-sm font-medium text-neutral-800 transition hover:bg-neutral-100">
                Validasi Gesture
            </button>

            <a href="{{ route('cashier.pos') }}"
               class="rounded-xl border border-neutral-300 bg-white px-5 py-3 text-sm font-medium text-neutral-800 transition hover:bg-neutral-100">
                Simulasi Masuk
            </a>
        </div>
    </section>

    <aside class="space-y-6">
        <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold tracking-tight text-neutral-900">Status Login</h3>

            <div class="mt-4 space-y-3">
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-neutral-500">Gesture Terbaca</p>
                    <p class="mt-2 text-base font-medium text-neutral-900">Belum ada</p>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-neutral-50 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-neutral-500">Status</p>
                    <p class="mt-2 inline-flex rounded-full border border-neutral-300 px-3 py-1 text-sm font-medium text-neutral-700">
                        Menunggu validasi
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold tracking-tight text-neutral-900">Catatan</h3>
            <ul class="mt-4 space-y-2 text-sm leading-6 text-neutral-600">
                <li>- Gesture diproses di browser dengan JavaScript.</li>
                <li>- Webcam aktif setelah izin kamera diberikan.</li>
                <li>- Jika gesture valid, kasir masuk ke halaman POS.</li>
            </ul>
        </div>
    </aside>
</div>
@endsection