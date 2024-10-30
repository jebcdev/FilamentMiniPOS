<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseDetails extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'purchase_price',
        'sale_price',
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalAttribute():float
    {
        return $this->quantity * $this->purchase_price;
    }

    protected static function booted(): void
    {
        static::creating(function ($purchaseDetails) {

            $product = $purchaseDetails->product; // Obtener el producto
            $product->stock += $purchaseDetails->quantity; // Sumar la cantidad de productos comprados al stock
            $product->save(); // Guardar el cambio en el producto


        });
    }
}
