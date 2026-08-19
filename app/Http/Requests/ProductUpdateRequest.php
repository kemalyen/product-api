<?php

namespace App\Http\Requests;

use App\Enums\ProductStatus;
use App\Rules\ValidProductPrice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product')->id;

        return [
            'name' => ['sometimes', 'required', 'string', 'min:3', 'max:255'],
            'description' => ['sometimes', 'required', 'string', 'min:10', 'max:1000'],
            'price' => ['sometimes', 'required', 'numeric', new ValidProductPrice()],
            'category_id' => ['nullable', 'integer'],
            'sku' => ['sometimes', 'required', 'string', 'regex:/^[A-Z0-9]{4,25}$/', Rule::unique('products', 'sku')->ignore($productId)],
            'barcode' => ['sometimes', 'required', 'string', 'max:50'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'status' => ['sometimes', Rule::enum(ProductStatus::class)],
            'published_at' => ['sometimes', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.min' => 'Product name must be at least 3 characters',
            'description.min' => 'Product description must be at least 10 characters',
            'sku.regex' => 'SKU must be 4-25 uppercase alphanumeric characters',
        ];
    }
}
