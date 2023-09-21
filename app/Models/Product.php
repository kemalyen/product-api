<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'options',   
        'option_values'
    ];
    
    protected $casts = [
        'status' => 'bool',
        'options' => 'json',
        'option_values' => 'json',
        'published_at' => 'date:Y-m-d H:i'
    ];

    protected $dates = ['published_at'];

    public function variants()
    {
        return $this->hasMany(Product::class, 'parent_id');
    }
}