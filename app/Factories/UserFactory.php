<?php

namespace App\Factories;

use App\Models\User;

class UserFactory
{
    public static function create(): User
    {
        $user = new User;
        $user->name = '';
        $user->email = '';
        $user->password = '';
        $user->account_id = '';
        return $user;
    }
 
}

