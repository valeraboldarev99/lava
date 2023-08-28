<?php

namespace App\Helpers;

use App\Modules\Structure\Models\Structure;

class PagesStructure
{
    public function getPage()
    {
        $prefix = request()->segment(1, '');
        $url = implode('/', array_slice(request()->segments(), 0));
        if($prefix && in_array($prefix, config("localization.locales")))
        {
            $prefix_pos = strpos($url, $prefix);
            $slug = substr($url, $prefix_pos + strlen($prefix) + 1, strlen($url));
        }
        else {
            $slug = $url;
        }

        if($prefix == $url && in_array($prefix, config("localization.locales")))
        {
        	$slug = '';
        }

        if(home() == $slug)
        {
            $page = Structure::where('slug', '')->first();
        }
        else {
            $str = strpos($slug, "/");
            if ($str) {
                $slug = substr($slug, $str + 1, strlen($slug));
            }
            $page = Structure::where('slug', $slug)->first();
        }
        return $page;
    }

    public function getPagesRoutes() {
        $pages = Structure::items()->where('depth', '<>', 0)->get();
        $routes = [];
    
        foreach ($pages as $key => $page)
        {
            $routes[$key] = [
                'route_name' => $page->slug,
                'slug' => self::getFullUrl($page),
            ];
        }

        return $routes;
    }

    public function getFullUrl($page)
    {
        if($page->redirector)
        {
            return $page->redirect_url;
        }
        else {
            $path = [$page->slug];
            $parent = $page->parent;
        
            while ($parent) {
                array_unshift($path, $parent->slug);
                $parent = $parent->parent;
            }
            
            return implode('/', $path);
        }
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