<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_name',
        'description'
    ];

    /**
     * The attributes that are mass sortable.
     *
     * @var array
     */
    protected $sortable = [
        'category_name',
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
