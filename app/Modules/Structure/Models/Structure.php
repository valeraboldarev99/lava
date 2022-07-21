<?php

namespace App\Modules\Structure\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    use Notifiable;

    protected $table = 'structure';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function children() {
        return $this->hasMany(Structure::class, 'parent_id');
    }

    public function parent() {
        return $this->belongsTo(Structure::class);
    }
}