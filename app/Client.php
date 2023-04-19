<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Client extends Model
{
    use Sortable;

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
     * The attributes that are mass sortable.
     *
     * @var array
     */
    public $sortable = [
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
