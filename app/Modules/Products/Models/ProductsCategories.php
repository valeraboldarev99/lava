<?php

namespace App\Modules\Products\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;
use App\Modules\AdminPanel\Models\FileUploader;

class ProductsCategories extends Model
{
	use Notifiable, Sortable, FileUploader;

    protected $table = 'products_categories';

    public function scopeOrder($query)
    {
        return $query->orderBy('position', 'desc')->orderBy('title');
    }

    public function scopeAdmin($query)
    {
        return $query->orderBy('position', 'desc')->orderBy('title');
    }
}