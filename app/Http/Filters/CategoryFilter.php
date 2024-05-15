<?php

namespace App\Http\Filters;

class CategoryFilter extends QueryFilter {

    protected $sortable = [
        'name',
    ];
  
    public function name($value) {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('name', 'like', $likeStr);
    }
 

}