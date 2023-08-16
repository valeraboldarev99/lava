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
        'products_multi_images2'  => 'products_images2',
        'products_multi_files2'   => 'products_files2',
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductsCategories::class, 'category_id');
    }

    public function scopeOrder($query)
    {
        return $query->orderBy('position', 'desc')->orderBy('title');
    }

    public function scopeAdmin($query)
    {
        return $query->orderBy('position', 'desc')->orderBy('title');
    }

    public function images1()
    {
        return $this->hasMany(ProductsImages1::class, 'parent_id', 'id')->orderBy('position');
    }

    public function files1()
    {
        return $this->hasMany(ProductsFiles1::class, 'parent_id', 'id')->orderBy('position');
    }

    public function images2()
    {
        return $this->hasMany(ProductsImages2::class, 'parent_id', 'id')->orderBy('position');
    }

    public function files2()
    {
        return $this->hasMany(ProductsFiles2::class, 'parent_id', 'id')->orderBy('position');
    }
}