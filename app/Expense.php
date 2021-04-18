<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $hidden = ['id','expense_category_id', 'user_id'];
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function expenseCategory()
    {
        return $this->belongsTo('App\ExpenseCategory');
    }
}
