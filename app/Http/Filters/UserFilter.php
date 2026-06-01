<?php

namespace App\Http\Filters;

class UserFilter extends QueryFilter
{
    protected $sortable = [
        'name',
        'email'
    ];

    public function include(string $value)
    {
        return $this->builder->with($value);
    }

    public function name(string $value)
    {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('name', 'like', $likeStr);
    }

    public function account(int $value)
    {
        return auth()->user()->hasRole('Admin') ? $this->builder->where('account_id', $value) : $this->builder->where('account_id', auth()->user()->account_id);
    }


    public function email(string $value)
    {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('email', 'like', $likeStr);
    }

    public function role($value)
    {
        return $this->builder->role($value);
    }
}
