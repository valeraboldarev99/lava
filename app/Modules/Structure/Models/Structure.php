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
        return $this->hasMany(Structure::class, 'parent_id', 'id');
    }

    public function getAllDescendants()
    {
        $descendants = $this->children;

        foreach ($this->children as $child) {
            $childDescendants = $child->getAllDescendants();
            $descendants = $descendants->merge($childDescendants);
        }

        return $descendants;
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
        $parent = Structure::where('id', $value)->first();
        if ($value == NULL) {
            $this->attributes['depth'] = 0;
            $this->attributes['parent_id'] = $value;
        }
        else {
            $this->attributes['depth'] = ++$parent->depth;
            $this->attributes['parent_id'] = $value;
        }
    }

    public function scopeOrder($query)
    {
        return $query->orderBy('position');
    }

    public function scopeAdmin($query)
    {
        return $query->orderBy('position');
    }
}