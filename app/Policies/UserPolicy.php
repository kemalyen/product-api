<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return ($user->hasRole('Admin') || $user->hasRole('Account Api User'))
        ? Response::allow()
        : Response::deny('You do not have access');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): Response
    {
        return ($user->hasRole('Admin') || ($user->hasRole('Account Api User') && $user->account_id === $model->account_id))
        ? Response::allow()
        : Response::deny('You do not have access to view this user.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return ($user->hasRole('Admin') || $user->hasRole('Account Api User'))
            ? Response::allow()
            : Response::deny('You do not have access to update this user.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): Response
    {
        return ($user->hasRole('Admin') || ($user->hasRole('Account Api User') && $user->account_id === $model->account_id))
            ? Response::allow()
            : Response::deny('You do not have access to update this user.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): Response
    {
        return ($user->hasRole('Admin') || ($user->hasRole('Account Api User') && $user->account_id === $model->account_id))
        ? Response::allow()
        : Response::deny('You do not have access to delete this user.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): Response
    {
        return ($user->hasRole('Admin') || ($user->hasRole('Account Api User') && $user->account_id === $model->account_id))
        ? Response::allow()
        : Response::deny('You do not have access to delete this user.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): Response
    {
        return ($user->hasRole('Admin') || ($user->hasRole('Account Api User') && $user->account_id === $model->account_id))
        ? Response::allow()
        : Response::deny('You do not have access to delete this user.');
    }
}
