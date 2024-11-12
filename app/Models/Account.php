<?php

namespace App\Models;

use App\Enums\AccountStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'account_number', 'status'];

    protected $casts = [
        'role' => AccountStatus::class,
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function product_prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }
/* 
    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, ProductPrice::class);
    } */
}
