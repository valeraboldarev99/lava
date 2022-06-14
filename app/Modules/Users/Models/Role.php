<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'id',
    ];

    public $timestamps = false;
}