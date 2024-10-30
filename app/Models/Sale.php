<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Sale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'date',
        'sale_number',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetails::class);
    }

    // Método para calcular el total de la compra
    public function getTotalAttribute(): float
    {
        // Sumar el total de cada detalle de la compra
        return $this->saleDetails->sum(fn($detail) => ($detail->quantity * $detail->sale_price));
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sale) {
            if (!$sale->user_id) {
                $sale->user_id = Auth::id() ?? 1;
            }
        });
    }
}
