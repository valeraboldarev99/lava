<?php

namespace App\Modules\Settings\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use Notifiable;

    protected $table = 'settings';

    protected $guarded = ['id'];

    public $timestamps = false;
}