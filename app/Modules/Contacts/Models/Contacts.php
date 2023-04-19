<?php

namespace App\Modules\Contacts\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;

class Contacts extends Model {

    use Notifiable, Sortable;

    protected $fillable = ['datetime', 'email', 'phone', 'name', 'message', 'ip'];

    protected $table = 'contacts';

    public function scopeOrder($query)
    {
        return $query->orderBy('datetime', 'desc');
    }
}