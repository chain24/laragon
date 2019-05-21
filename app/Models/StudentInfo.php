<?php

namespace App\Models;


class StudentInfo extends Model
{
    protected $table = 'students_info';

    protected $fillable = ['student_id'];

    public function student()
    {
        return $this->belongsTo('App\User');
    }
}
