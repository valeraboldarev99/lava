<?php

namespace App\Modules\News\Models;

use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;
use App\Modules\AdminPanel\Models\FileUploader;

class News extends Model {

    use Notifiable, FileUploader;

    protected $table = 'news';
}