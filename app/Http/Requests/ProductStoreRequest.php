<?php

namespace App\Http\Requests;

use App\Rules\ValidProductPrice;
use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->account_id !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:10', 'max:1000'],
            'price' => ['required', 'numeric', new ValidProductPrice()],
            'category_id' => ['nullable', 'integer'],
            'sku' => ['required', 'string', 'regex:/^[A-Z0-9]{4,25}$/'],
            'barcode' => ['required', 'string', 'max:50'],
            'quantity' => ['sometimes', 'integer', 'min:0'],
            'status' => ['sometimes', 'string', 'in:A,P,X'],
            'published_at' => ['sometimes', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required',
            'name.min' => 'Product name must be at least 3 characters',
            'description.required' => 'Product description is required',
            'description.min' => 'Product description must be at least 10 characters',
            'price.required' => 'Product price is required',
            'sku.regex' => 'SKU must be 4-25 uppercase alphanumeric characters',
            'barcode.required' => 'Product barcode is required',
        ];
    }
}
