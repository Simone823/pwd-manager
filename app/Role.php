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
     * RELAZIONE ONE TO MANY CON USERS
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * RELAZIONE MANY TO MANY CON PERMISSIONS
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }
}
