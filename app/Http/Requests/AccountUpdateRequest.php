<?php

namespace App\Http\Requests;

use App\Enums\AccountStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountUpdateRequest extends AccountRequest
{
    public function rules(): array
    {
        $account = $this->route('account');

        return [
            'name' => ['sometimes', 'required', 'string', 'min:2', 'max:255', Rule::unique('accounts', 'name')->ignore($account)],
            'account_number' => ['sometimes', 'required', 'digits_between:2,10', Rule::unique('accounts', 'account_number')->ignore($account)],
            'status' => ['sometimes', 'required', Rule::in(array_column(AccountStatus::cases(), 'value'))],
        ];
    }

    public function messages(): array
    {
        return [
            'name.min' => 'Account name must be at least 2 characters',
            'account_number.digits_between' => 'Account number must be between 2 and 10 digits',
            'status.in' => 'Account status must be one of: ' . implode(', ', array_column(AccountStatus::cases(), 'value')),
        ];
    }
}
