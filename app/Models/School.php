<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{

    protected $table = 'schools';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'about', 'medium', 'code', 'theme',
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

}
