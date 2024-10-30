<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Purchase extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'date',
        'purchase_number',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function purchaseDetails(): HasMany
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    // Método para calcular el total de la compra
    public function getTotalAttribute(): float
    {
        // Sumar el total de cada detalle de la compra
        return $this->purchaseDetails->sum(fn($detail) => ($detail->quantity * $detail->purchase_price));
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($purchase) {
            if (!$purchase->user_id) {
                $purchase->user_id = Auth::id() ?? 1;
            }
        });
    }
}
