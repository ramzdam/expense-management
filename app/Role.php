<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ADMINISTRATOR = 1;
    const USER = 2;
    
    public function userRole()
    {
        return $this->hasMany('App\UserRole');
    }
}
