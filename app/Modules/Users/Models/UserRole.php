<?php

namespace App\Modules\Users\Models;

use App\Modules\AdminPanel\Models\Model;

class UserRole extends Model
{
    protected $table = 'user_roles';

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    public $timestamps = false;
}