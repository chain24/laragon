<?php

namespace App\Models;


class StudentInfo extends Model
{
    protected $table = 'student_infos';

    protected $fillable = ['student_id'];

    public function student()
    {
        return $this->belongsTo('App\User');
    }
}
