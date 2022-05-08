<?php

namespace App\Policies;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpensePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isOwner();
    }

    public function view(User $user, Expense $expense)
    {
        return $user->isOwner();
    }


    public function create(User $user)
    {
        return $user->isOwner();
    }

    public function update(User $user, Expense $expense)
    {
        return $user->isOwner();
    }

    public function delete(User $user, Expense $expense)
    {
        return false;
    }

    public function deleteAny(User $user)
    {
        return false;
    }
}
