<?php

namespace App\Http\Requests;

use App\Rules\ValidProductPrice;
use Illuminate\Foundation\Http\FormRequest;

class PriceUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->account_id !== null;
    }

    public function rules(): array
    {
        return [
            'price' => ['required', 'numeric', new ValidProductPrice()],
        ];
    }

    public function messages(): array
    {
        return [
            'price.required' => 'Price is required',
        ];
    }
}

