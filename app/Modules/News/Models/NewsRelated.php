<?php

namespace App\Modules\News\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;

class NewsRelated extends Model {

    use Notifiable, Sortable;

    protected $table = 'news_related';
}