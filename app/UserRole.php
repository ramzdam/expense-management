<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    const ADMIN = 1;
    const USER = 2;

    protected $hidden = ['id'];
    protected $guarded = ['id'];

    protected $attributes = [
        'can_create_user' => false,
        'can_update_user' => false,
        'can_delete_user' => false,
        'can_create_expense' => false,
        'can_update_expense' => false,
        'can_delete_expense' => false,
        'can_create_expense_category' => false,
        'can_update_expense_category' => false,
        'can_delete_expense_category' => false,
        'can_view_user_management' => false,
        'can_change_password' => false,
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }


    public function getCanCreateUserAttribute($value)
    {
        return $value ? true : false;
    }

    public function getCanUpdateUserAttribute($value)
    {
        return $value ? true : false;
    }

    public function getCanDeleteUserAttribute($value)
    {
        return $value ? true : false;
    }

    public function getCanUpdateExpenseAttribute($value)
    {
        return $value ? true : false;
    }

    public function getCanCreateExpenseAttribute($value)
    {
        return $value ? true : false;
    }
    
    public function getCanDeleteExpenseAttribute($value)
    {
        return $value ? true : false;
    }

    public function getCanCreateExpenseCategoryAttribute($value)
    {
        return $value ? true : false;
    }
    
    public function getCanUpdateExpenseCategoryAttribute($value)
    {
        return $value ? true : false;
    }
    
    public function getCanDeleteExpenseCategoryAttribute($value)
    {
        return $value ? true : false;
    }

    public function getCanViewUserManagementAttribute($value)
    {
        return $value ? true : false;
    }

    public function getCanChangePasswordAttribute($value)
    {
        return $value ? true : false;
    }
    
}
