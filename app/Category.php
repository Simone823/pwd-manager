<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * RELAZIONE ONE TO MANY CON ACCOUNTS PASSWORD
     */
    public function accounts()
    {
        return $this->hasMany('App\AccountPassword');
    }
}
