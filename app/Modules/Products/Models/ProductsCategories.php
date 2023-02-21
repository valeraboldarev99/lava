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
}