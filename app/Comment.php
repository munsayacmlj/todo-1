<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function task() {
    	return $this->belongsTo('App\Task');
    }

    public function user() {
    	return $this->belongsTo('App\User');
    }
}
