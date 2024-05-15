<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

 
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'product',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'sku' => $this->sku,
                'barcode' => $this->barcode,
                'publishedAt' => $this->published_at,
                'status' => $this->status,
                'quantity' => $this->quantity,
                'price' => $this->price
            ],
            'relationships' => [
                'category' => [
                    'data' => [
                        'type' => 'category',
                        'id' => $this->category_id
                    ],
                    'links' => [
                        'self' => route('categories.show', ['category' => $this->category_id])
                    ]
                ]
            ],
            'includes' => new CategoryResource($this->whenLoaded('category')),
            'links' => [
                'self' => route('products.show', ['product' => $this->id])
            ]
        ];
    }
}
