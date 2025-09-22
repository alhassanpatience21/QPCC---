<?php

namespace App\Policies;

use App\Models\Deposit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepositPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role == User::ADMIN
            || $user->role == User::AGENT;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deposit  $deposit
     * @return mixed
     */
    public function view(User $user, Deposit $deposit)
    {
        return $user->role == User::ADMIN
            || $user->role == User::AGENT;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role == User::ADMIN
            || $user->role == User::AGENT;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deposit  $deposit
     * @return mixed
     */
    public function update(User $user, Deposit $deposit)
    {
        return $user->role == User::ADMIN
            || $user->role == User::AGENT;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deposit  $deposit
     * @return mixed
     */
    public function delete(User $user, Deposit $deposit)
    {
        return $user->role == User::ADMIN
            || $user->role == User::AGENT;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deposit  $deposit
     * @return mixed
     */
    public function restore(User $user, Deposit $deposit)
    {
        return $user->role == User::ADMIN
            || $user->role == User::AGENT;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deposit  $deposit
     * @return mixed
     */
    public function forceDelete(User $user, Deposit $deposit)
    {
        return $user->role == User::ADMIN
            || $user->role == User::AGENT;
    }
}
