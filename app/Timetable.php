<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $table = 'timetable';
    
    public function user() {
        return $this->belongsTo('App\User');
    }
}
