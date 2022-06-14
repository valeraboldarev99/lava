<?php

namespace App\Modules\Users\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'remember_token',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function isAdmin()
    {
        return $this->roles()->where('name', 'admin')->exists();
    }

    public function isUser()
    {
        return $this->roles()->where('name', 'user')->exists();
    }

    public function isDisabled()
    {
        return $this->roles()->where('name', 'disabled')->exists();
    }
}