<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'barcode',
        'description',
        'published_at',
        'status',
        'price',
        'quantity',
        'category_id'
    ];

    protected $casts = [
        'published_at' => 'date:Y-m-d H:i'
    ];

    protected $dates = ['published_at'];

    protected $appends = ['account_price'];

    public function getAccountPriceAttribute(): float
    {
        $price =  $this->product_prices->where('account_id', auth()->user()->account_id)->first()->price ?? $this->price;
        return $price;
    }

    public function getCategoryNameAttribute()
    {
        return $this->category?->name;
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function product_prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }
}