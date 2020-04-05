<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed name
 * @property mixed vk_user_id
 * @property mixed city
 * @property mixed state
 * @property mixed random_id
 * @property mixed coordinates
 * @property mixed lat
 * @property mixed lng
 */
class User extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'vk_user_id', 'city', 'state', 'random_id', 'coordinates','lat','lng',
    ];
}
