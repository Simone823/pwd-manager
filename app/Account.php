<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'client_id',
        'category_id',
        'url',
        'username',
        'password',
        'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];


    /**
     * RELAZIONE ONE TO MANY INVERSE CON CLIENTS
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    /**
     * RELAZIONE ONE TO MANY INVERSE CON CATEGORIES
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
