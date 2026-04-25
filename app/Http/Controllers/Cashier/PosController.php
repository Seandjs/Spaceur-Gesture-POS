<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PosController extends Controller
{
    public function index(): View
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum('subtotal');
        $totalItems = collect($cart)->sum('qty');

        return view('cashier.pos', compact('cart', 'total', 'totalItems'));
    }

    public function addToCart(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::where('code', $validated['code'])->first();

        if (! $product) {
            return redirect()
                ->route('cashier.pos')
                ->with('error', 'Produk dengan kode tersebut tidak ditemukan.');
        }

        $cart = session('cart', []);
        $productId = $product->id;
        $qty = (int) $validated['qty'];

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] += $qty;
            $cart[$productId]['subtotal'] = $cart[$productId]['qty'] * $cart[$productId]['price'];
        } else {
            $cart[$productId] = [
                'product_id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'category' => $product->category,
                'size' => $product->size,
                'price' => $product->price,
                'qty' => $qty,
                'subtotal' => $product->price * $qty,
            ];
        }

        session(['cart' => $cart]);

        return redirect()
            ->route('cashier.pos')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function removeFromCart(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer'],
        ]);

        $cart = session('cart', []);
        unset($cart[$request->product_id]);

        session(['cart' => $cart]);

        return redirect()
            ->route('cashier.pos')
            ->with('success', 'Produk dihapus dari keranjang.');
    }

    public function clearCart(): RedirectResponse
    {
        session()->forget('cart');

        return redirect()
            ->route('cashier.pos')
            ->with('success', 'Keranjang berhasil dikosongkan.');
    }

    public function checkout(): RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cashier.pos')
                ->with('error', 'Keranjang masih kosong.');
        }

        DB::beginTransaction();

        try {
            $totalAmount = collect($cart)->sum('subtotal');

            $sale = Sale::create([
                'invoice_number' => $this->generateInvoiceNumber(),
                'cashier_id' => null,
                'total_amount' => $totalAmount,
            ]);

            foreach ($cart as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            DB::commit();

            session()->forget('cart');

            return redirect()
                ->route('cashier.pos')
                ->with('success', 'Pembayaran berhasil. Transaksi tersimpan dengan invoice ' . $sale->invoice_number . '.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()
                ->route('cashier.pos')
                ->with('error', 'Terjadi kesalahan saat menyimpan transaksi.');
        }
    }

    private function generateInvoiceNumber(): string
    {
        $date = now()->format('Ymd');
        $countToday = Sale::whereDate('created_at', now()->toDateString())->count() + 1;

        return 'INV-' . $date . '-' . str_pad((string) $countToday, 3, '0', STR_PAD_LEFT);
    }

    public function salesHistory(): View
    {
        $sales = Sale::latest()->get();

        return view('cashier.sales.index', compact('sales'));
    }

    public function salesShow(Sale $sale): View
    {
        $sale->load('items.product');

        return view('cashier.sales.show', compact('sale'));
    }
}
