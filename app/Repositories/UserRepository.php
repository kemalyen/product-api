<?php

namespace App\Repositories;

use App\Models\User;
use Auth;
use Spatie\Permission\Models\Role;

class UserRepository
{
    public function save(array $data, User $user) : ?User
    {

        $authenticated_user = auth()->user();

        if(empty($account_id) ) {
           $data['account_id'] = $authenticated_user->account_id;

        }elseif(!$authenticated_user->hasRole('Admin') && !empty($data['account_id'])) {
            $data['account_id'] = $authenticated_user->account_id;
        
        }else{
            $data['account_id'] = $data['account_id'];
        }
 
       
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