<?php

namespace App\Policies;

use App\Models\Request;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        return true;
    }


    public function view(User $user, Request $request)
    {
        return true;
    }


    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Request $request)
    {
        return true;
    }

    public function delete(User $user, Request $request)
    {
        return false;
    }

    public function deleteAny(User $user)
    {
        return false;
    }
}
