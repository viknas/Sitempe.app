<?php

namespace App\Policies;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isOwner();
    }


    public function view(User $user, Sale $sale)
    {
        return $user->isOwner();
    }


    public function create(User $user)
    {
        return $user->isOwner();
    }

    public function update(User $user, Sale $sale)
    {
        return $user->isOwner();
    }

    public function delete(User $user, Sale $sale)
    {
        return false;
    }

    public function deleteAny(User $user)
    {
        return false;
    }
}
