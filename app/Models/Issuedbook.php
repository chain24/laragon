<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issuedbook extends Model
{
    protected $table = 'issued_books';
    public function book()
    {
        return $this->belongsTo('App\Models\Book');
    }
}
