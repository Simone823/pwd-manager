<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];


    /**
     * RELAZIONE ONE TO MANY TO USERS
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
