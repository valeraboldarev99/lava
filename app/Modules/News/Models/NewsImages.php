<?php

namespace App\Modules\News\Models;

use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;

class NewsImages extends Model {

    use Notifiable;

    protected $table = 'news_images';
}