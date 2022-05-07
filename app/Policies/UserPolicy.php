<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isOwner();
    }


    public function view(User $user, User $userInstance)
    {
        return $user->isOwner();
    }


    public function create(User $user)
    {
        return $user->isOwner();
    }

    public function update(User $user, User $userInstance)
    {
        return $user->id == $userInstance->id;
    }

    public function delete(User $user, User $userInstance)
    {
        return $user->isOwner();
    }

    public function deleteAny(User $user)
    {
        return false;
    }
}
