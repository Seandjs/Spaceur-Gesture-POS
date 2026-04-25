@extends('layouts.app')

@section('content')
<div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
    <section class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
        @if (session('error'))
            <div class="mb-4 rounded-2xl border border-red-200 bg-white p-4 text-sm text-red-600 shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-5">
            <p class="text-sm font-medium text-neutral-500">Modul Kasir</p>
            <h2 class="mt-1 text-2xl font-semibold tracking-tight text-neutral-900">Login Gesture Tangan</h2>
            <p class="mt-2 text-sm leading-6 text-neutral-600">
                Masukkan kode gesture dengan benar untuk membuka sistem kasir.
            </p>
        </div>

        <div class="relative overflow-hidden rounded-2xl border border-neutral-300 bg-black">
            <video id="gesture-video" autoplay playsinline muted class="aspect-video w-full object-cover"></video>
            <canvas id="gesture-canvas" class="absolute inset-0 h-full w-full"></canvas>
        </div>

        <div class="mt-5 flex flex-wrap gap-3">
            <button type="button" id="start-camera-btn"
                class="rounded-xl bg-neutral-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-neutral-800 cursor-pointer">
                Mulai Kamera
            </button>

            <button type="button" id="reset-gesture-btn"
                class="rounded-xl border border-neutral-300 bg-white px-5 py-3 text-sm font-medium text-neutral-800 transition hover:bg-neutral-100 cursor-pointer">
                Reset
            </button>
        </div>
    </section>

    <aside class="space-y-6">
        <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold tracking-tight text-neutral-900">Status Login</h3>

            <div class="mt-4 space-y-3">
                <div class="rounded-2xl border border-neutral-200 bg-neutral-50 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-neutral-500">Gesture Terdeteksi</p>
                    <p id="gesture-name" class="mt-2 text-base font-medium text-neutral-900">Belum ada</p>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-neutral-50 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-neutral-500">Progress Kode</p>
                    <p id="gesture-progress" class="mt-2 text-base font-medium text-neutral-900">0 / 3</p>
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-neutral-50 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-neutral-500">Status</p>
                    <p id="gesture-status"
                       class="mt-2 inline-flex rounded-full border border-neutral-300 px-3 py-1 text-sm font-medium text-neutral-700">
                        Menunggu kamera
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold tracking-tight text-neutral-900">Informasi</h3>
            <ul class="mt-4 space-y-2 text-sm leading-6 text-neutral-600">
                <li>- Sistem membaca beberapa jenis gesture tangan.</li>
                <li>- Hanya kode gesture yang benar yang bisa membuka POS.</li>
                <li>- Jika urutan salah, progress akan direset.</li>
            </ul>
        </div>
    </aside>
</div>
@endsection

@push('scripts')
    @vite('resources/js/gesture-login.js')
@endpush