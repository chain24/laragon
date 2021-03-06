<?php

namespace App\Models;

class Routine extends Model
{
    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }

    public function school()
    {
        return $this->belongsTo('App\Models\School');
    }
}
