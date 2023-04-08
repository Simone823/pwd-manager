<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * RELAZIONE ONE TO MANY INVERSE CON ROLE
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }


    /**
     * CONTROLLA SE L'UTENTE HA IL RUOLO
     * @param string
     * @return boolean
     */
    public function hasRole(string $roleName): bool
    {
        // first letter upper
        $roleName = ucfirst($roleName);
        
        // recupero il ruolo dal db by roleName
        $role = Role::where('name', $roleName)->first();

        // controllo il ruolo dell'utente
        if($this->role_id == $role->id) {
            return true;
        }

        return false;
    }

    /**
     * CONTROLLA SE L'UTENTE è ADMIN
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
}
