<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategory extends Model
{
    use SoftDeletes;
    protected $hidden = ['id','deleted_at'];
    protected $guarded = ['id'];

    public function expense()
    {
        return $this->hasMany('App\Expense');
    }
}
