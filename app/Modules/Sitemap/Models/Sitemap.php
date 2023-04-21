<?php

namespace App\Modules\Sitemap\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Route;

class Sitemap
{
    /**
     * Название папки модуля.
     *
     * @var string
     */
    protected $module;

    /**
     * Название класса модели.
     *
     * @var string
     */
    protected $model;

    /**
     * Название роута.
     *
     * @var string
     */
    protected $route;

    /**
     * Параметры по умолчанию.
     *
     * @var array
     */
    protected $defaultParams = [
        'changefreq' => 'daily',
        'priority'   => '0.8'
    ];

    /**
     * Создание экземпляра класса.
     *
     * @param string $module
     * @return void
     */
    public function __construct(string $module)
    {
        $this->module = $module;

        if (is_null($this->model)) {
            $this->model = $module;
        }

        if (is_null($this->route)) {
            $this->route = lcfirst($module) . '.show';
        }
    }

    /**
     * Получение списка страниц модуля.
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getLocs(int $limit, int $offset) : array
    {
        $entities = $this->getEntities($limit, $offset);
        $result = [];

        foreach ($entities as $entity) {
            $result[] = $this->prepareLoc($entity);
        }

        return $result;
    }

    /**
     * Получение записей таблицы.
     * Сначала со стандартной локали, потом с остальных языков в указанном в конфиге порядке
     *
     * @param int $limit
     * @param int $offset
     * @return Collection
     */
    protected function getEntities(int $limit, int $offset) : Collection
    {
        $items = $this->getModel()
                        ->newQueryWithoutScopes()
                        ->limit($limit)
                        ->active()
                        ->orderByRaw('FIELD(lang, ' . $this->getLocalesPriority() .')')
                        ->offset($offset)
                        ->get();

        return $items;
    }

    /**
     * Получение отформатированных данных записи.
     *
     * @param $entity
     * @return array
     */
    protected function prepareLoc($entity) : array
    {
        $loc = array_merge(['loc' => $this->getUrl($entity)], $this->defaultParams);

        if (isset($entity->updated_at) && $entity->updated_at) {
            $loc['lastmod'] = $this->getLastMod($entity->updated_at);
        }

        return $loc;
    }

    /**
     * Получение ссылки на запись с любой локали
     *
     * @param $entity
     * @return string
     */
    protected function getUrl($entity) : string
    {
        if(Route::has($this->route)) {
            $prefix = '';
            
            if (isset($entity->lang) && $entity->lang != config('localization.locale')) {
                $prefix .= '/' . $entity->lang;
            }
            
            $site = host();
            $body = route($this->route, ['id' => $entity->getRouteKey()], false);

            return $site . $prefix . $body;
        }

        return '';
    }

    /**
     * Получение даты последнего изменения записи.
     *
     * @param Carbon $updatedAt
     * @return string
     */
    protected function getLastMod(Carbon $updatedAt) : string
    {
        return $updatedAt->format('c');
    }

    /**
     * Получение объекта модели.
     *
     * @return Model
     */
    protected function getModel() : Model
    {
        $className = '\App\Modules\\' . $this->module . '\Models\\' . $this->model;
        return new $className();
    }

    /**
     * Возвращает приоритет локалей из конфига
     *
     * @return string
     */
    public function getLocalesPriority() : string
    {
        $locales = getModuleConfig('settings.locales_priority');

        if ($locales) {
            // Обернём в кавычки для sql синтаксиса
            $quoted = array_map(function ($item) {
                return '"' . $item . '"';
            }, $locales);

            return implode(',', $quoted);
        }

        return config('app.locale');
    }
}
