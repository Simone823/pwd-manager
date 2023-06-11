<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable
{
    use Notifiable;
    use Sortable;

    // Attributes
    public /* string */ $passwordDemoUser = "!DemoPwdManager!23!!...#";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'username',
        'email',
        'password'
    ];

    /**
     * The attributes that are mass sortable.
     *
     * @var array
     */
    public $sortable = [
        'name',
        'surname',
        'username',
        'email',
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
     * @param string $roleName
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
     * CONTROLLA SE L'UTENTE HA IL PERMESSO
     * @param string $permissionName
     * @return boolean
     */
    public function hasPermission(string $permissionName): bool
    {
        // format permissionName
        $permissionName = strtolower($permissionName);

        // recupero dal db il permesso by permissionName
        $permissionInstance = Permission::where('name', $permissionName)->first();
        
        // ciclo i permessi legati al ruolo utente e controllo il permesso
        foreach ($this->role->permissions as $permission) {
            if($permission->name == $permissionInstance->name) {
                return true;
            }
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
