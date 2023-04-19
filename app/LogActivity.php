<?php

namespace App;

use App\LogActivity as AppLogActivity;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Request;

class LogActivity extends Model
{
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action',
        'url', 
        'method',
        'ip',
        'agent',
        'user_id'
    ];

    /**
     * The attributes that are mass sortable.
     *
     * @var array
     */
    public $sortable = [
        'action',
        'url', 
        'method',
        'ip',
        'agent',
        'user_id'
    ];


    /**
     * AGGIUNGI UN LOG SUL DB TABELLA LOG ACTIVITY
     *
     * @param string $actionName
     * @return void
     */
    public static function addLog(string $actionName): void
    {
        // new log
        $newLog = new AppLogActivity();

        // setto i valori
        $newLog->action = ucwords($actionName);
        $newLog->url = Request::fullUrl();
        $newLog->method = Request::method();
        $newLog->ip = Request::ip();
        $newLog->agent = Request::header('user-agent');
        $newLog->user_id = Auth::check() ? Auth::user()->id : null;

        // save
        $newLog->save();
    }
}
