<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
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
     * RELAZIONE MANY TO MANY CON ROLES
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
