<?php

namespace App\Http\Requests;

use App\Enums\AccountStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255', 'unique:accounts'],
            'account_number' => ['required', 'digits_between:2,10', 'unique:accounts'],
            'status' => ['required', Rule::in(array_column(AccountStatus::cases(), 'value'))],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Account name is required',
            'name.min' => 'Account name must be at least 2 characters',
            'account_number.required' => 'Account number is required',
            'account_number.digits_between' => 'Account number must be between 2 and 10 digits',
            'status.required' => 'Account status is required',
            'status.in' => 'Account status must be one of: ' . implode(', ', array_column(AccountStatus::cases(), 'value')),
        ];
    }
}
