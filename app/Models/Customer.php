<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'zip_code',
        'address',
        'city',
        'state',
        'country',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
