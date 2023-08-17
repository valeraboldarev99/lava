<?php

namespace App\Modules\News\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;
use App\Modules\AdminPanel\Models\FileUploader;

class News extends Model {

    use Notifiable, Sortable, FileUploader;

    protected $table = 'news';

    protected $multipleFilesTables = [
        'multi_images'  => 'news_images',
        'multi_files'   => 'news_files',
    ];

    public function images()
    {
    	return $this->hasMany(NewsImages::class, 'parent_id', 'id')->orderBy('position', 'asc');
    }

    public function files()
    {
    	return $this->hasMany(NewsFiles::class, 'parent_id', 'id')->orderBy('position', 'desc');
    }

    public function scopeOrder($query)
    {
        return $query->orderBy('position', 'desc')->orderBy('title');
    }

    public function scopeAdmin($query)
    {
        return $query->orderBy('position', 'desc')->orderBy('title');
    }
}