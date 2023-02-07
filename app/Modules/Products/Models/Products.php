<?php

namespace App\Modules\Products\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;
use App\Modules\AdminPanel\Models\FileUploader;

class Products extends Model {

    use Notifiable, FileUploader, Sortable;

    protected $table = 'products';

    protected $sortable = ['title', 'category_id'];

    public function productCategory()
    {
        return $this->belongsTo(ProductsCategories::class, 'category_id');
    }

    public function scopeOrder($query)
    {
        return $query->orderBy('title')->latest();
    }
}