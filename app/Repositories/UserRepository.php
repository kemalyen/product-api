<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function save(array $data, User $user): ?User
    {
        $authenticated_user = auth()->user();

        $data['account_id'] = $this->getAccountId($data, $authenticated_user);
        $user->fill($data);
        $user->save();
        $user->assignRole($data['role']);
        return $user;
    }

    public function update(array $data, User $user): ?User
    {
        $user->update($data);
        $user->assignRole($data['role']);
        return $user;
    }

    private function getAccountId(array $data, User $authenticated_user): int
    {
        if (empty($data['account_id'])) {
            $account_id = $authenticated_user->account_id;
        } elseif (!$authenticated_user->hasRole('Admin') && !empty($data['account_id'])) {
            $account_id = $authenticated_user->account_id;
        } else {
            $account_id = $data['account_id'];
        }
        return $account_id;
    }
}
