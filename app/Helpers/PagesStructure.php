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
        $pages = Structure::items()->where('depth', '<>', 0)->where('module', NULL)->get();

        return self::getRouteNames($pages);
    }

    private function getRouteNames($pages)
    {
        foreach ($pages as $key => $page) {
            if($page->parent_id == NULL)
            {
                if($page->module)
                {
                    $page->route_name = $page->module . '.index';
                }
                else {
                    $page->route_name = $page->slug;
                }
            }
            else {
                $parent = Structure::where('id', $page->parent_id)->first();
                if($page->module)
                {
                    $page->route_name = $page->slug . '.index';
                    $page->slug = $page->slug;
                }
                else {
                    $page->slug = $parent->slug . '/' . $page->slug;
                    $page->route_name = $page->slug;
                }
            }
        }
        return $pages;
    }

    private function getPageUrl($pages)
    {
        foreach ($pages as $page)
        {
            if($page->redirector)
            {
                $page->slug = $page->redirect_url;
            }
            else {
                $page->slug = '/' . $page->slug; 
            }
        }

        return $pages;
    }

    public function getMainMenu()
    {
        $pages = Structure::items()->where('depth', '<>', 0)->where('in_main_menu', 1)->get();
        
        return self::getPageUrl($pages);
    }

    public function getFooterMenu()
    {
        $pages = Structure::items()->where('depth', '<>', 0)->where('in_bottom_menu', 1)->get();
        
        return self::getPageUrl($pages);
    }
}