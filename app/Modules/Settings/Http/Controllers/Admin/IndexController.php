<?php

namespace App\Modules\Settings\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Modules\Settings\Models\Settings;
use App\Modules\AdminPanel\Http\Controllers\Admin\AdminMainController;

class IndexController extends AdminMainController
{
    protected $viewPrefix = 'Settings';
    protected $routePrefix = 'admin.settings.';

    public function getModel()
    {
        return new Settings();
    }

    public function getRules($request, $id = false)
    {
        return [
            'name' => 'sometimes|required',
            'slug' => [
                        'sometimes', 'required',
                        Rule::unique('settings')->ignore($id),
                    ],
        ];
    }

    public function shortStore(Request $request)
    {
        $request_array = $request->all();
        
        $setting = $this->getModel()->where('slug', $request_array['slug'])->first();
        if(isset($setting))
        {
            $setting->content = $request_array['content'];
            $setting->update();
        }
        else {
            $this->getModel()->create($request->all());
        }

        return redirect()->back();
        dd($request_array, $setting);
    }
}