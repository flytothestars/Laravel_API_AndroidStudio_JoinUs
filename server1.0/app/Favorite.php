<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Event;

class Favorite extends Model
{
    public function event(){
        return $this->belongTo(Event::class);
    }    
}
