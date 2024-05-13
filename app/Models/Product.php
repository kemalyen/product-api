<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

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
    ];
    
    protected $casts = [
        'published_at' => 'date:Y-m-d H:i'
    ];

    protected $dates = ['published_at'];

    public function scopeFilter(Builder $builder, QueryFilter $filters) {
        return $filters->apply($builder);
    }
 
}