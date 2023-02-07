<?php

namespace App\Modules\Structure\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;

class Structure extends Model
{
    use Notifiable, Sortable;

    protected $table = 'structure';

    protected $guarded = ['id'];

    public function children() {
        return $this->hasMany(Structure::class, 'parent_id');
    }

    public function parent() {
        return $this->belongsTo(Structure::class);
    }

    public function getModules()
    {
        $modules = ['' => ''] + config('Structure.settings.modules');
        return $modules;
    }

    public function getTemplates()
    {
        $templates = config('Structure.settings.templates');
        return $templates;
    }

    public function setParentIdAttribute($value)
    {
        if ($value == NULL) {
            $this->attributes['depth'] = 1;
            $this->attributes['parent_id'] = $value;
        }
        else {
            $this->attributes['depth'] = 2;
            $this->attributes['parent_id'] = $value;
        }
    }

    public function scopeOrder($query)
    {
        return $query->orderBy('depth')->orderBy('title');
    }
}