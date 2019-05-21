<?php

namespace App\Models;

class Myclass extends Model
{
    protected $table = 'classes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_number', 'group', 'school_id',
    ];
    /**
     * Get the school record associated with the user.
     */
    public function school()
    {
        return $this->belongsTo('App\Models\School');
    }
    public function sections()
    {
        return $this->hasMany('App\Models\Section','class_id');
    }
    // public function exam()
    // {
    //     return $this->belongsTo('App\ExamForClass');
    // }
    public function books()
    {
        return $this->hasMany('App\Models\Book','class_id');
    }
}
