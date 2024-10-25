<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\Response;


class AccountPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('Admin')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return ($user->hasRole('Admin'))
            ? Response::allow()
            : Response::deny('You do not have access to view this resource.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Account $account): Response
    {
        return ($user->hasRole('Admin') || ($user->hasRole('Account Api User') && $user->account_id === $account->id))
            ? Response::allow()
            : Response::deny('You do not have access to view this user.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return ($user->hasRole('Admin'))
            ? Response::allow()
            : Response::deny('You do not have access to create an account.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Account $account): Response
    {
        return ($user->hasRole('Admin') || ($user->hasRole('Account Api User') && $user->account_id === $account->account_id))
            ? Response::allow()
            : Response::deny('You do not have access to update this account.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Account $account): bool
    {
        return ($user->hasRole('Admin'))
            ?  true 
            :  false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Account $account): bool
    {
        return ($user->hasRole('Admin'))
            ?  true 
            :  false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Account $account): bool
    {
        return ($user->hasRole('Admin'))
            ?  true 
            :  false;
    }
}
