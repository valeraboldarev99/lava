<?php

namespace App\Helpers;

use App\Modules\Structure\Models\Structure;

class PagesStructure
{
    public function getPage()
    {
        $segments = request()->segments();
        $lastSegment = end($segments);

        if($lastSegment && in_array($lastSegment, config("localization.locales")))
        {
            return Structure::where('slug', '')->first();
        }
        else {
            return Structure::where('slug', $lastSegment)->first();
        }
    }

    public function getPagesRoutes() {
        $pages = Structure::items()->where('depth', '<>', 0)->get();
        $routes = [];
    
        foreach ($pages as $key => $page)
        {
            if($page->module)
            {
                $routes[$key] = [
                    'route_name' => $page->slug,
                    'slug' => self::getFullUrl($page),
                    'action' => 'App\Modules\\' . ucfirst($page->module) . '\Http\Controllers\IndexController@index',
                ];
            }
            else {
                $routes[$key] = [
                    'route_name' => $page->slug,
                    'slug' => self::getFullUrl($page),
                    'action' => 'App\Modules\Structure\Http\Controllers\IndexController@index'
                ];
            }
        }
        return $routes;
    }

    public function getFullUrl($page)
    {
        $path = [$page->slug];
        $parent = $page->parent;
    
        while ($parent) {
            array_unshift($path, $parent->slug);
            $parent = $parent->parent;
        }
        
        return implode('/', $path);
    }

    public function getMainMenu()
    {
        return Structure::items()->where('depth', 1)->where('in_main_menu', 1)->get();
    }

    public function getFooterMenu()
    {
        return Structure::items()->where('depth', 1)->where('in_bottom_menu', 1)->get();
    }
}