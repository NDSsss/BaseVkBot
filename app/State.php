<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public $timestamps = false;

    public function triggerWords(){
        return $this->hasMany(TriggerWord::class,'state_id','id');
    }
}
