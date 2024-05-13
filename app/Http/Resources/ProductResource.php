<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   @OA\Xml(name="ProductResource"),
 *   @OA\Property(property="data", type="array",
 *      @OA\Items(ref="#/components/schemas/Product"))
 *   ),
 * )
 */
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
            'status'  => $this->status,
            'quantity' => $this->quantity,
            'price' => $this->price
            ]
        ];
    }
}
