<?php

namespace App\Modules\Settings\Models;

use Illuminate\Notifications\Notifiable;
use App\Modules\AdminPanel\Models\Model;

class Settings extends Model
{
    use Notifiable;

    protected $table = 'settings';

    public $timestamps = false;

    const TYPE = [
        'html'			=> 'Текст',
        'wysiwyg'		=> 'Визуальный редактор'
    ];

    public function getType()
    {
        return self::TYPE;
    }

    public function scopeOrder($query)
    {
        return $query->orderBy('name');
    }
}