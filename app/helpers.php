<?php

use App\Modules\Settings\Models\Settings;
use Illuminate\Support\Facades\Schema;
use App\Helpers\PagesStructure;
use Illuminate\Support\Str;

/**
 * return full host name
 */
if (!function_exists('host')) {
    function host()
    {
        return sprintf("%s://%s", host_protocol(), $_SERVER['SERVER_NAME']);
    }
}
/**
 * return host protocol http or https
 */
if (!function_exists('host_protocol')) {
    function host_protocol()
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
    }
}
/**
    * return link to homepage with current language : string
*/
if (!function_exists('home')) {
    function home()
    {
        return url('/' . getLang());
    }
}

/**
    * return all modules name : array
*/
if (!function_exists('modules_all')) {
    function modules_all()
    {
        return array_diff(scandir(config('modules.path')), array('.','..'));
    }
}

/**
    * return all modules name : collect
*/
if (!function_exists('modules_collect')) {
    function modules_collect()
    {
        $modules_array = array_diff(scandir(config('modules.path')), array('.','..'));
        $modules_collect = collect();
        foreach($modules_array as $module)
        {
            $modules_collect[$module] = $module;
        }
        return $modules_collect;
    }
}

/**
    * return setting's data from Settings table : entity
    * @param $slug - (slug field) string
*/
if(!function_exists('getSetting')) {
    function getSetting($slug)
    {
        return Settings::where('slug', $slug)->where('active', 1)->value('content');
    }
}

/**
    * return current language : string
*/
if(!function_exists('getLang')) {
    function getLang()
    {
        $locale = request()->segment(1, '');
        if($locale == config('cms.url.admin_prefix') || $locale == '')
        {
            $locale = config('app.locale');
        }
        if($locale && in_array($locale, config("localization.locales"))) {
            return $locale;
        }

        return config('app.locale');
    }
}

/**
    * return page's data from Structure table : entity
*/
if(!function_exists('getPage')) {
    function getPage()
    {
        return PagesStructure::getPage();
    }
}

/**
    * return this url without site name : string
*/
if(!function_exists('getUrl')) {
    function getUrl()
    {
        return implode('/', array_slice(request()->segments(), 0));
    }
}

/**
    * return admins localization link for language : string
    * @param $locale - (language name, for example: 'en') string
*/
if(!function_exists('adminLocale')) {
    function adminLocale($locale)
    {
        if(strpos(getUrl(), getLang()) == 0)
        {
            $url =  str_replace(getLang(), '', getUrl());
        }
        else {
            $url = getUrl();
        }

        if(strpos($url, '/') == 0)
        {
            $url = substr($url, 1, strlen($url));
        }
        $url = '/' . $locale .  '/' . $url;

        return $url;
    }
}

/**
    * checks if there is localization in this module : bool
    * @param $model_name - (module name, passed to all admin's views) string
*/
if(!function_exists('checkModelLocalization')) {
    function checkModelLocalization($model_name)
    {
        if(config($model_name . '.settings') == NULL)
        {
            if(config(getModule() . '.settings') == NULL)
            {
                $result = false;
            }
            else {
                return config(getModule() . '.settings.localization');
            }
        }
        $result = config($model_name . '.settings.localization');
        if($result == NULL)
        {
            $result = false;
        }

        return $result;
    }
}

/**
    * return Method name : string
*/
if(!function_exists('getMethod')) {
    function getMethod()
    {
        $uses_action =  request()->route()->action['uses'];
        $uses_action = explode('@', $uses_action);

        return  $uses_action[1];
    }
}

/**
    * return module name : string
*/
if(!function_exists('getModule')) {
    function getModule()
    {
        $uses_action =  request()->route()->action['uses'];
        preg_match('!App\\\Modules\\\(.*)\\\!isU', $uses_action, $res);
        if (!isset($res[1])) {
            return false;
        }

        return $res[1];
    }
}

/**
    * return model path : string
*/
if(!function_exists('getModelPath')) {
    function getModelPath($model = null)
    {
        if(!$model)
        {
            $uses_action =  request()->route()->action['uses'];
            preg_match('!App\\\Modules\\\(.*)\\\!isU', $uses_action, $res);
            if (!isset($res[1])) {
                return false;
            }
            return $res[0] . 'Models\\' . $res[1];                                          //$res[0] - module path, $res[1] - module name
        }
        else {
            return 'App\Modules\\'. $model .'\Models\\'. $model;
        }
    }
}

/**
    * return module's configs : array
    * @param $arg - (file name, and if you need - path to value) string
    * @param $module - (module name) string, nullable
    * @param $default - (default value) string, nullable
*/
if(!function_exists('getModuleConfig')) {
    function getModuleConfig($arg, $module = null, $default = null)
    {
        if (!$module) {
            $module = getModule();

            if (!$module) {
                return false;
            }
        }
        
        $value = $module . '.' . $arg;

        if(config($value) == NULL)
        {
            return $default;
        }

        return config($value);
    }
}

/**
    * return table name : string
    * @param $module - (module name) string, nullable
*/
if(!function_exists('getTableName')) {
    function getTableName($module = null)
    {
        if(!$module)
        {
            $modelPath = getModelPath();
            $model = new $modelPath;
            
            if(isset($model))
            {
                return $model->getTable();
            }
            else {
                return Str::snake(Str::pluralStudly(class_basename(getModule())));
            }
        }
        else {
            $modelPath = getModelPath($module);
            $model = new $modelPath;

            if(isset($model))
            {
                return $model->getTable();
            }
            else {
                return Str::snake(Str::pluralStudly(class_basename($module)));
            }
        }
    }
}

/**
    * return table fields name : string
    * @param $tableName - string, nullable
*/
if(!function_exists('getTableFields')) {
    function getTableFields($tableName = null)
    {
        if(!$tableName)
        {
            return Schema::getColumnListing(getTableName());
        }
        else {
            return Schema::getColumnListing($tableName);
        }
    }
}