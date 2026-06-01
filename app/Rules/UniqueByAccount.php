<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueByAccount implements ValidationRule
{
    public function __construct(
        private string $table,
        private string $column,
        private ?int $ignoreId = null,
    ) {}

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $user = auth()->user();
        if (!$user || !$user->account_id) {
            $fail('Unable to determine account.');
            return;
        }

        $query = DB::table($this->table)
            ->where('account_id', $user->account_id)
            ->where($this->column, $value);

        if ($this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }

        if ($query->count() > 0) {
            $fail("The {$this->column} already exists for this account.");
        }
    }
}
