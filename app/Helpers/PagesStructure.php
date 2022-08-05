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

        foreach ($pages as $key => $page) {
            if($page->parent_id == NULL)
            {
                if($page->module)
                {
                    $page->route_name = $page->slug . '.index';
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
}