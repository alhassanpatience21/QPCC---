<?php

namespace App\Policies;

use App\Models\Commission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComissionPolicy
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
        return $user->role == User::ADMIN;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Commission  $commission
     * @return mixed
     */
    public function view(User $user, Commission $commission)
    {
        return $user->role == User::ADMIN;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role == User::ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Commission  $commission
     * @return mixed
     */
    public function update(User $user, Commission $commission)
    {
        return $user->role == User::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Commission  $commission
     * @return mixed
     */
    public function delete(User $user, Commission $commission)
    {
        return $user->role == User::ADMIN;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Commission  $commission
     * @return mixed
     */
    public function restore(User $user, Commission $commission)
    {
        return $user->role == User::ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Commission  $commission
     * @return mixed
     */
    public function forceDelete(User $user, Commission $commission)
    {
        return $user->role == User::ADMIN;
    }
}
