<?php

namespace App\Modules\Users\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use Notifiable, Sortable;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password',
    ];
    
    protected $dates = ['last_online_at'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function scopeFiltered($query)       //filtered()
    {
        return $query->where('id', '<>', 1);
    }

    public function scopeAdmin($query)          //admin()
    {
        return $query->order();
    }

    public function scopeOrder($query)          //order()
    {
        $query->orderBy('name')->orderBy('id')->latest();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id');
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