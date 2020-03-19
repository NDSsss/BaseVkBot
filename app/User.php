<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'vk_user_id', 'city', 'state', 'random_id',
    ];

    public function state(){
        return $this->hasOne(State::class,'id','state_id');
    }
}
