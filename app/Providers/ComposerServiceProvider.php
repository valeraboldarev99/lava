<?php

namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $modules = modules_all();

        if($modules) {
            foreach ($modules as $module)
            {
                $providers = config($module . '.settings.providers');
                if($providers)
                {
                    foreach ($providers as $key => $value) {
                        View::composer($value, $key);
                    }
                }
            }
        }

        // View::composers([
        //     // 'App\Modules\AdminPanel\Http\ViewComposers\MenuComposer' => ['AdminPanel::common.sidebar'],
        // ]);

        // Использование построителей на основе класса...

        // Использование построителей на основе замыканий...
        View::composer('dashboard', function ($view) {
            //
        });
    }

    public function register()
    {
        //
    }
}