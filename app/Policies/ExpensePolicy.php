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
        return true;
    }


    public function view(User $user, Expense $expense)
    {
        return true;
    }


    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Expense $expense)
    {
        return true;
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
