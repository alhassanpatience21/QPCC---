<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Auth\Access\HandlesAuthorization;

class WithdrawalPolicy
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
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return mixed
     */
    public function view(User $user, Withdrawal $withdrawal)
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
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return mixed
     */
    public function update(User $user, Withdrawal $withdrawal)
    {
        return $user->role == User::ADMIN
            || $user->role == User::AGENT;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return mixed
     */
    public function delete(User $user, Withdrawal $withdrawal)
    {
        return $user->role == User::ADMIN
            || $user->role == User::AGENT;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return mixed
     */
    public function restore(User $user, Withdrawal $withdrawal)
    {
        return $user->role == User::ADMIN
            || $user->role == User::AGENT;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return mixed
     */
    public function forceDelete(User $user, Withdrawal $withdrawal)
    {
        return $user->role == User::ADMIN
            || $user->role == User::AGENT;
    }
}
