<?php

namespace App\Models;


class Department extends Model
{
    public function teachers(){
        return $this->hasMany('App\User','department_id');
    }
}
