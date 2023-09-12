<?php

namespace App\Modules\Backuper\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;

class Backuper extends Model {

    use Notifiable, Sortable;

    protected $table = 'backuper';

    public $timestamps = false;

    protected $dates = [
        'datetime',
        'date_from',
        'date_to',
    ];

    public function scopeOrder($query)
    {
        return $query->orderBy('datetime', 'desc');
    }
}