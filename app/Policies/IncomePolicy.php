<?php

namespace App\Policies;

use App\Models\Income;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IncomePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isOwner();
    }


    public function view(User $user, Income $income)
    {
        return false;
    }


    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Income $income)
    {
        return false;
    }

    public function delete(User $user, Income $income)
    {
        return false;
    }

    public function deleteAny(User $user)
    {
        return false;
    }
}
