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
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'options' => $this->options,
            'option_values' => $this->option_values,
            'published_at' => $this->published_at,
            'status'  => $this->status,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'variants' => ProductResource::collection($this->whenLoaded('variants')),
        ];
    }
}
