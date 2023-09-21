<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' =>  'required|max:255',
            'sku' =>  'required|unique:products|max:25',
            'barcode' => 'required|unique:products|max:25',
            'options' => 'array',
            'option_values' => 'json',
            'published_at' => 'required|date',
            'status' =>  'required|boolean',
            'quantity' => 'integer',
            'price' => 'numeric'
        ];
    }
}
