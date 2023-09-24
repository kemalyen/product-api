<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   @OA\Xml(name="Product"),
 *   @OA\Property(format="int64", title="ID", default=1, description="ID", property="id"),
 *   @OA\Property(format="string", title="name", default="Js Originals relaxed t-shirt with globe back", description="Name", property="name"),
 *   @OA\Property(format="string", title="sku", default="204645590", description="Sku", property="sku"),
 *   @OA\Property(format="string", title="barcode", default="00123456789012", description="", property="barcode"),
 *   @OA\Property(format="json", title="options", default="{'Size}", description="", property="options"),
 *   @OA\Property(format="json", title="option_values", default="{'Size' => 'SMall'}", description="", property="option_values"), 
 *   @OA\Property(format="string", title="description", default="Js Originals relaxed t-shirt with globe back, 2023 new style!", description="Product description", property="description"), 
 *   @OA\Property(format="int", title="quantity", default="48", description="quantity", property="quantity"), 
 *   @OA\Property(format="float", title="price", default="13.50", description="Product price", property="price"),   
 * )
 */
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