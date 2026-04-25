@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm font-medium text-neutral-500">Modul Kasir</p>
            <h2 class="mt-1 text-2xl font-semibold tracking-tight text-neutral-900">Riwayat Transaksi</h2>
            <p class="mt-2 text-sm leading-6 text-neutral-600">
                Daftar transaksi yang sudah berhasil disimpan.
            </p>
        </div>

        <a href="{{ route('cashier.pos') }}"
           class="inline-flex items-center rounded-xl border border-neutral-300 bg-white px-5 py-3 text-sm font-medium text-neutral-800 transition hover:bg-neutral-100">
            Kembali ke POS
        </a>
    </div>

    <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-neutral-200 text-neutral-500">
                        <th class="px-3 py-3 font-medium">Invoice</th>
                        <th class="px-3 py-3 font-medium">Tanggal</th>
                        <th class="px-3 py-3 font-medium">Total</th>
                        <th class="px-3 py-3 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-neutral-800">
                    @forelse ($sales as $sale)
                        <tr class="border-b border-neutral-100">
                            <td class="px-3 py-4">{{ $sale->invoice_number }}</td>
                            <td class="px-3 py-4">{{ $sale->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-3 py-4">{{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                            <td class="px-3 py-4">
                                <a href="{{ route('cashier.sales-show', $sale->id) }}"
                                   class="rounded-lg border border-neutral-300 px-3 py-2 text-xs font-medium text-neutral-700 transition hover:bg-neutral-100">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-6 text-center text-sm text-neutral-500">
                                Belum ada transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection