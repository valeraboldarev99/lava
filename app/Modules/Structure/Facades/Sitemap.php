<?php

namespace App\Modules\Structure\Facades;

use App\Helpers\PagesStructure;
use App\Modules\Sitemap\Models\Sitemap as MainSitemap;

class Sitemap extends MainSitemap
{
    protected $route = 'structure.index';

    protected $defaultParams = [
        'changefreq' => 'daily',
        'priority'   => '1'
    ];

    protected function getUrl($entity) : string
    {
        $url = '';

        if ($entity->lang != config('localization.locale')) {
            $url .= $entity->lang . '/';
        }

        $url .= $entity->slug;

        return host() . '/' .$url;
    }
}
