<?php

namespace App\Http\Requests;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->route('user');
        return $this->user() && $this->user()->account_id === $user->account_id;
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name' => ['sometimes', 'required', 'string', 'min:2', 'max:255'],
            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user),
            ],
            'password' => ['sometimes', 'string', 'min:8'],
            'role' => ['sometimes', 'required', Rule::in(array_column(Role::cases(), 'value'))],
        ];
    }

    public function messages(): array
    {
        return [
            'name.min' => 'User name must be at least 2 characters',
            'email.email' => 'Email must be a valid email address',
            'password.min' => 'Password must be at least 8 characters',
        ];
    }
}
