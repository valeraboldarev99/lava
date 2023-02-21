<?php

namespace App\Modules\Products\Models;

use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;

class ProductsFiles1 extends Model {

    use Notifiable;

    protected $table = 'products_files1';
}