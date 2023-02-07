<?php

namespace App\Modules\AdminPanel\Models;

use Illuminate\Database\Eloquent\Model as ParentModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class Model extends ParentModel
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        static::bootTraits();

        static::creating(function ($model) {
            with(new static)->beforeCreate($model);
        });
        static::updating(function ($model) {
            with(new static)->beforeSave($model);
        });

        with(new static)->addGlobalScopes();
    }

    public static function getTableStatic()
    {
        return with(new static)->getTable();
    }

    protected function addGlobalScopes()
    {
        if (Schema::hasColumn(self::getTableStatic(), 'lang')) {
            static::addGlobalScope('lang', function (Builder $builder) {
                $builder->where('lang', getLang());
            });
        }
    }

    protected function beforeCreate($model)
    {
        $columns = Schema::getColumnListing($model->getTable());
        if (in_array('lang', $columns)) {
            $model->lang = getLang();
        }
    }

    protected function beforeSave($model)
    {
        //
    }

    public function scopeAdmin($query)          //admin()
    {
        return $query->order();
    }

    public function scopeOrder($query)          //order()
    {
        return $query;
    }

    public function scopeActive($query)         //active()
    {
        return $query->where('active', 1);
    }

    public function scopeItems($query)              //Structure::items()->where('depth', '<>', 0)->get();
    {
        return $query->order()->active();
    }
}