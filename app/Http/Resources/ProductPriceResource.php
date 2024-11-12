<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

 
class ProductPriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'product_price',
            'id' => $this->id,
            'attributes' => [
                'account_id' => $this->account_id,
                'product_id' => $this->product_id,
                'price' => $this->price
            ],
            'includes' => new ProductResource($this->whenLoaded('product')),
            
            'links' => [
                'self' => route('products.show', ['product' => $this->product_id])
            ]
        ];
    }
}
