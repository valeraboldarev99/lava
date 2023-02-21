<?php

namespace App\Modules\Users\Models;

use App\Modules\AdminPanel\Models\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'id',
    ];

    public $timestamps = false;
}