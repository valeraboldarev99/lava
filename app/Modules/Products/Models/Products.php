<?php

namespace App\Modules\Products\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;
use App\Modules\AdminPanel\Models\FileUploader;

class Products extends Model {

    use Notifiable, FileUploader, Sortable;

    protected $table = 'products';

    protected $multipleFilesTables = [
        'products_multi_images1'  => 'products_images1',
        'products_multi_files1'   => 'products_files1',
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductsCategories::class, 'category_id');
    }

    public function scopeOrder($query)
    {
        return $query->orderBy('title')->latest();
    }

    public function images1()
    {
        return $this->hasMany(ProductsImages1::class, 'parent_id', 'id')->orderBy('position');
    }

    public function files1()
    {
        return $this->hasMany(ProductsFiles1::class, 'parent_id', 'id')->orderBy('position');
    }
}