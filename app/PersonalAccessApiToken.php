<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalAccessApiToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token_name',
        'token_code',
        'abilities'
    ];
}
