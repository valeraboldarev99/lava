<?php

namespace App\Modules\Search\Models;

use App\Modules\AdminPanel\Models\Model;

class SearchHistory extends Model {

    protected $table = 'search_history';
    protected $guarded = ['id'];
    public $timestamps = false;

}