<?php

namespace App\OpenAPI;


/**
 * @OA\Schema(
 *   @OA\Xml(name="ProductWithVariants"),
 *   @OA\Property(format="int64", title="ID", default=22, description="ID", property="id"),
 *   @OA\Property(format="string", title="name", default="Js Originals relaxed t-shirt with globe back", description="Name", property="name"),
 *   @OA\Property(format="string", title="sku", default="204645590", description="Sku", property="sku"),
 *   @OA\Property(format="string", title="barcode", default="00123456789012", description="", property="barcode"),
 *   @OA\Property(format="json", title="options", default="['Size']}", description="", property="options"),
 *   @OA\Property(format="json", title="option_values", default="", description="", property="option_values"), 
 *   @OA\Property(format="string", title="description", default="Js Originals relaxed t-shirt with globe back, 2023 new style!", description="Product description", property="description"), 
 *   @OA\Property(format="int", title="quantity", default="23", description="quantity", property="quantity"), 
 *   @OA\Property(format="float", title="price", default="13.50", description="Product price", property="price"), 
 *   @OA\Property(title="variants", property="variants", type="array", description="Product variants", @OA\Items(ref="#/components/schemas/ProductVariant"))
 * )
 */

class ProductWithVariants
{
}
