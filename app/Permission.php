<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Permission extends Model
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
     * RELAZIONE MANY TO MANY CON ROLES
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
