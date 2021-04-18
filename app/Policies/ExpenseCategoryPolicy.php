<?php

namespace App\Policies;

use App\ExpenseCategory;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpenseCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any expense categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the expense category.
     *
     * @param  \App\User  $user
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return mixed
     */
    public function view(User $user, ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Determine whether the user can create expense categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the expense category.
     *
     * @param  \App\User  $user
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return mixed
     */
    public function update(User $user, ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Determine whether the user can delete the expense category.
     *
     * @param  \App\User  $user
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return mixed
     */
    public function delete(User $user, ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Determine whether the user can restore the expense category.
     *
     * @param  \App\User  $user
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return mixed
     */
    public function restore(User $user, ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the expense category.
     *
     * @param  \App\User  $user
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return mixed
     */
    public function forceDelete(User $user, ExpenseCategory $expenseCategory)
    {
        //
    }
}
