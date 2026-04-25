@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm font-medium text-neutral-500">Detail Transaksi</p>
            <h2 class="mt-1 text-2xl font-semibold tracking-tight text-neutral-900">{{ $sale->invoice_number }}</h2>
            <p class="mt-2 text-sm leading-6 text-neutral-600">
                Tanggal transaksi: {{ $sale->created_at->format('d-m-Y H:i') }}
            </p>
        </div>

        <a href="{{ route('cashier.sales-history') }}"
           class="inline-flex items-center rounded-xl border border-neutral-300 bg-white px-5 py-3 text-sm font-medium text-neutral-800 transition hover:bg-neutral-100">
            Kembali ke Riwayat
        </a>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <section class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold tracking-tight text-neutral-900">Item Transaksi</h3>

            <div class="mt-4 overflow-x-auto">
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
                        @foreach ($sale->items as $item)
                            <tr class="border-b border-neutral-100">
                                <td class="px-3 py-4">{{ $item->product->code ?? '-' }}</td>
                                <td class="px-3 py-4">
                                    {{ $item->product->name ?? 'Produk' }}
                                    @if($item->product)
                                        - {{ $item->product->size }}
                                    @endif
                                </td>
                                <td class="px-3 py-4">{{ $item->qty }}</td>
                                <td class="px-3 py-4">{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="px-3 py-4">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold tracking-tight text-neutral-900">Ringkasan</h3>

                <div class="mt-4 space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-neutral-500">Invoice</span>
                        <span class="font-medium text-neutral-900">{{ $sale->invoice_number }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-neutral-500">Jumlah Item</span>
                        <span class="font-medium text-neutral-900">{{ $sale->items->sum('qty') }}</span>
                    </div>
                    <div class="flex items-center justify-between border-t border-neutral-200 pt-4">
                        <span class="text-base font-semibold text-neutral-900">Total</span>
                        <span class="text-xl font-semibold text-neutral-900">
                            {{ number_format($sale->total_amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection