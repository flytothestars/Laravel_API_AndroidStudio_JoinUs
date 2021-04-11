<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Event;

class Comment extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function event(){
        return $this->belongsTo(Event::class);
    }
}
