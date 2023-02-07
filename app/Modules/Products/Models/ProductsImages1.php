<?php

namespace App\Modules\Products\Models;

use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;

class ProductsImages1 extends Model {

    use Notifiable;

    protected $table = 'products_images1';
}