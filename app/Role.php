<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Role extends Model
{
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that are mass sortable.
     *
     * @var array
     */
    public $sortable = [
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
