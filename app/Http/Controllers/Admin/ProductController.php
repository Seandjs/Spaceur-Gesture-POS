<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Picqer\Barcode\BarcodeGeneratorSVG;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'size' => ['required', 'string', 'max:50'],
            'price' => ['required', 'integer', 'min:0'],
        ]);

        $validated['code'] = $this->generateProductCode();

        $barcodePath = $this->generateBarcodeFile($validated['code']);
        $validated['barcode_path'] = $barcodePath;

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Data barang dan barcode berhasil disimpan.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'size' => ['required', 'string', 'max:50'],
            'price' => ['required', 'integer', 'min:0'],
        ]);

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->barcode_path && Storage::disk('public')->exists($product->barcode_path)) {
            Storage::disk('public')->delete($product->barcode_path);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Data barang berhasil dihapus.');
    }

    private function generateProductCode(): string
    {
        $lastProduct = Product::latest('id')->first();

        if (! $lastProduct) {
            return 'SPCR-001';
        }

        $lastNumber = (int) str_replace('SPCR-', '', $lastProduct->code);
        $newNumber = $lastNumber + 1;

        return 'SPCR-' . str_pad((string) $newNumber, 3, '0', STR_PAD_LEFT);
    }

    private function generateBarcodeFile(string $code): string
    {
        $generator = new BarcodeGeneratorSVG();

        $barcodeSvg = $generator->getBarcode(
            $code,
            $generator::TYPE_CODE_128,
            2,
            60
        );

        $fileName = 'barcodes/' . $code . '.svg';

        Storage::disk('public')->put($fileName, $barcodeSvg);

        return $fileName;
    }

    public function downloadBarcode(Product $product)
    {
        if (! $product->barcode_path || ! Storage::disk('public')->exists($product->barcode_path)) {
            return redirect()
                ->route('admin.products.index')
                ->with('success', 'File barcode tidak ditemukan.');
        }

        $filePath = Storage::disk('public')->path($product->barcode_path);

        return response()->download($filePath, $product->code . '.svg');
    }
}
