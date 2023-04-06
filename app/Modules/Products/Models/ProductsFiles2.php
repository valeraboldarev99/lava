<?php

namespace App\Modules\Products\Models;

use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;

class ProductsFiles2 extends Model {

    use Notifiable;

    protected $table = 'products_files2';
}