<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', Rule::unique('products', 'sku')->ignore($this->product)],
            'barcode' => ['required', Rule::unique('products', 'barcode')->ignore($this->product)],
            'publishedAt' => 'required|date',
            'status' =>  'required|string|in:A,P,X',
            'quantity' => 'integer',
            'price' => 'numeric',
            'category_id' => 'required|exists:categories,id'
        ];
    }
 
}

