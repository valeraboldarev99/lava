<?php

namespace App\Modules\News\Models;

use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;

class NewsFiles extends Model {

    use Notifiable;

    protected $table = 'news_files';
}