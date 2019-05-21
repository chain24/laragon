<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 19.5.21
 * Time: 14:04
 */

namespace App\Models;


class Model extends \Illuminate\Database\Eloquent\Model
{
    public function scopeBySchool($query, int $school_id)
    {
        return $query->where('school_id', $school_id);
    }
}
