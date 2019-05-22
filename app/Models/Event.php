<?php

namespace App\Models;

class Event extends Model
{
    /**
     * Get the school record associated with the user.
     */
    public function school()
    {
        return $this->belongsTo('App\Models\School');
    }
}
