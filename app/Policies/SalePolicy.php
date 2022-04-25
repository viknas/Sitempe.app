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
        return true;
    }


    public function view(User $user, Sale $sale)
    {
        return true;
    }


    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Sale $sale)
    {
        return true;
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
