<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository
{
    public function create(array $data): Account
    {
        return Account::create($data);
    }

    public function update(array $data, Account $account): Account
    {
        $account->update($data);
        return $account;
    }
}
