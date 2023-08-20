<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invitation;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the invitation can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list invitations');
    }

    /**
     * Determine whether the invitation can view the model.
     */
    public function view(User $user, Invitation $model): bool
    {
        return $user->hasPermissionTo('view invitations');
    }

    /**
     * Determine whether the invitation can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create invitations');
    }

    /**
     * Determine whether the invitation can update the model.
     */
    public function update(User $user, Invitation $model): bool
    {
        return $user->hasPermissionTo('update invitations');
    }

    /**
     * Determine whether the invitation can delete the model.
     */
    public function delete(User $user, Invitation $model): bool
    {
        return $user->hasPermissionTo('delete invitations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete invitations');
    }

    /**
     * Determine whether the invitation can restore the model.
     */
    public function restore(User $user, Invitation $model): bool
    {
        return false;
    }

    /**
     * Determine whether the invitation can permanently delete the model.
     */
    public function forceDelete(User $user, Invitation $model): bool
    {
        return false;
    }
}
