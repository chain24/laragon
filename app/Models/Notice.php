<?php

namespace App\Models;

class Notice extends Model
{
    /**
     * Get the school record associated with the user.
     */
    public function school()
    {
        return $this->belongsTo('App\Models\School');
    }
}
