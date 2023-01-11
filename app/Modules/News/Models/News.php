<?php

namespace App\Modules\News\Models;

use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;
use App\Modules\AdminPanel\Models\FileUploader;

class News extends Model {

    use Notifiable, FileUploader;

    protected $table = 'news';

    protected $multipleFilesTables = [
        'multi_images'  => 'news_images',
        'multi_files'   => 'news_files',
    ];

    public function images()
    {
    	return $this->hasMany(NewsImages::class, 'parent_id', 'id')->orderBy('position');
    }

    public function files()
    {
    	return $this->hasMany(NewsFiles::class, 'parent_id', 'id')->orderBy('position');
    }
}