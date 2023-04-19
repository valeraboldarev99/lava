<?php

namespace App\Modules\Contacts\Http\Controllers\Admin;

use App\Modules\Contacts\Models\Contacts;
use App\Modules\AdminPanel\Http\Controllers\Admin\AdminMainController;
use Illuminate\Http\Request;

class IndexController extends AdminMainController
{
    protected $viewPrefix = 'Contacts';
    protected $routePrefix = 'admin.contacts.';

    public function getModel()
    {
        return new Contacts();
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function update(Request $request, $id)
    {
        abort(404);
    }
}