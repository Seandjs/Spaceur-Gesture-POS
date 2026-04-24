<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'code',
        'name',
        'category',
        'size',
        'price',
        'barcode_path',
    ];

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}