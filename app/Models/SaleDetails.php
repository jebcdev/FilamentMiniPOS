<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleDetails extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'sale_price',
    ];

    public function sale():BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalAttribute():float
    {
        return $this->quantity * $this->sale_price;
    }

    protected static function booted(): void
    {
        static::creating(function ($saleDetails) {

            $product = $saleDetails->product; // Obtener el producto
            $product->stock -= $saleDetails->quantity; // Restar la cantidad de productos vendidos al stock
            $product->save(); // Guardar el cambio en el producto

        });
    }
}
