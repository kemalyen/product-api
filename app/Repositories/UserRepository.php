<?php

namespace App\Repositories;

use App\Models\User;
use Auth;
use Spatie\Permission\Models\Role;

class UserRepository
{
    public function save(array $data, User $user) : ?User
    {
        $account_id = auth()->user()?->account_id;
        $user->account_id = $account_id;
        $user->fill($data);
        $user->save();
        $user->assignRole($data['role']);
        return $user;
    }

    
    public function update(array $data, User $user) : ?User
    {
        $user->update($data);
        $user->assignRole($data['role']);
        return $user;
    }  
}