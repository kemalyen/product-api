<?php

namespace App\Http\Filters;

class UserFilter extends QueryFilter {

    protected $sortable = [
        'name',
        'email'
    ];
 

    public function include($value) {
        return $this->builder->with($value);
    }
 

    public function name($value) {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('name', 'like', $likeStr);
    }

    public function account($value) {
        return $this->builder->where('account_id', $value);
    }
 
    
    public function email($value) {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('email', 'like', $likeStr);
    }

    public function role($value) {
        return $this->builder->role($value);
    }
}