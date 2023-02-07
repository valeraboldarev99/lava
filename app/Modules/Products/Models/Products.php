<?php

namespace App\Modules\Products\Models;

use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;
use App\Modules\AdminPanel\Models\FileUploader;

class Products extends Model {

    use Notifiable, FileUploader;

    protected $table = 'products';
}