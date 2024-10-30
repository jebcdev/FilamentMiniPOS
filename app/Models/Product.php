<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'code',
        'name',
        'description',
        'images',
        'stock',
        'min_stock',
        'max_stock',
        'purchase_price',
        'sale_price',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function purchaseDetails():HasMany
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function saleDetails():HasMany
    {
        return $this->hasMany(SaleDetails::class);
    }
}
