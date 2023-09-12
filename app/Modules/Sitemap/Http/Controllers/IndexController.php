<?php

namespace App\Modules\Sitemap\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class IndexController extends Controller
{
    private $structureModuleName = 'Structure';

    /**
     * generate robots
     */
    public function robots()
    {
        $view = 'Sitemap::robots.disallow';
        $data = [];

        if (config('cms.indexation')) {
            $view = 'Sitemap::robots.robots';
            $data['content'] = implode('', file(public_path('/robots/robots.txt')));
        }

        return response()->view($view, $data)->header('Content-Type', 'text/plain');
    }

    /**
     * generate sitemap
     */
    public function sitemap()
    {
        $limit = getModuleConfig('settings.limit');
        $modules = modules_collect();
        $items = [];
        $result = null;

        //сперва Модуль структуры сайта
        if (isset($modules[$this->structureModuleName])) {
            $structureModule = $modules->pull($this->structureModuleName);
            $modules->prepend($structureModule, $this->structureModuleName);
        }
        
        foreach ($modules as $module) {
            $searchedName = '\\App\\Modules\\' . $module . '\\Facades\\Sitemap';
            if (!class_exists($searchedName)) {
                continue;
            }
            $moduleSitemapFacade = new $searchedName($module);
            $items[] = $moduleSitemapFacade->getLocs($limit, 0);
        }

        if (empty($items)) {
            return false;
        }

        $items = collect($items)->flatten(1)->toArray();

        return response()->view('Sitemap::xml.index', ['params' => $items])->header('Content-Type', 'text/xml');
        // return $this->generateSitemapFile($items);
    }
    
    /**
     * @param $items
     * @return Sitemap-File
     */
    /*public function generateSitemapFile($items)
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>'  . "\r\n";
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'  . "\r\n";

        foreach($items as $item)
        {
            if($item['loc'])
            {
                $content .= "\t" . '<url>'  . "\r\n";
                    $content .= "\t\t" . '<loc>' . $item['loc'] . '</loc>'  . "\r\n";

                    if(isset($item['lastmod']))
                    {
                        $content .= "\t\t" . '<lastmod>' . $item['lastmod'] . '</lastmod>'  . "\r\n";
                    }

                    if(isset($item['changefreq'])){
                        $content .= "\t\t" . '<changefreq>' . $item['changefreq'] . '</changefreq>'  . "\r\n";
                    }

                    if(isset($item['priority']))
                    {
                        $content .= "\t\t" . '<priority>' . $item['priority'] . '</priority>'  . "\r\n";
                    }
                
                $content .= "\t" . '</url>'  . "\r\n";
            }
        }
        $content .= '</urlset>';

        $file = fopen(public_path() . '/robots/sitemap.xml', 'w') or die('Не удалось создать файл');
        fwrite($file, $content);
        fclose($file);
    }*/
}