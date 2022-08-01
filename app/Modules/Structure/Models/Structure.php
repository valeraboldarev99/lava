<?php

namespace App\Modules\Structure\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    use Notifiable;

    protected $table = 'structure';

    protected $guarded = ['id'];

    public function children() {
        return $this->hasMany(Structure::class, 'parent_id');
    }

    public function parent() {
        return $this->belongsTo(Structure::class);
    }

    public function getPagesRoutes() {
        $pages = Structure::where('depth', '<>', 0)->where('active', 1)->get();

        foreach ($pages as $key => $page) {
            if($page->parent_id == NULL)
            {
                if($page->module)
                {
                    $page->route_name = $page->slug . '.index';
                }
                else {
                    $page->route_name = $page->slug;
                }
            }
            else {
                $parent = Structure::where('id', $page->parent_id)->first();
                if($page->module)
                {
                    $page->route_name = $page->slug . '.index';
                    $page->slug = $page->slug;
                }
                else {
                    $page->slug = $parent->slug . '/' . $page->slug;
                    $page->route_name = $page->slug;
                }
            }
        }

        return $pages;
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
}