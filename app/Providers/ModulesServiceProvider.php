<?php

namespace App\Providers;

/* Сервис провайдер для подключения модулей */
class ModulesServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected function getDir($module){

        return config('modules.path') . '/' . ucfirst($module);
    }

    public function boot()
    {
        //получаем список модулей, которые надо подгрузить
        $modules = modules_all();

        if($modules) {
            foreach ($modules as $module) {
                //Подключаем роуты для модуля
                if(file_exists($this->getDir($module) . '/Routes/web.php'))
                {
                    $this->loadRoutesFrom($this->getDir($module) . '/Routes/web.php');
                }

                //Загружаем View
                if(is_dir($this->getDir($module) . '/Resources/Views'))
                {
                    $this->loadViewsFrom($this->getDir($module) . '/Resources/Views', $module);
                }

                //Подгружаем миграции
                if(is_dir($this->getDir($module) . '/Database/Migrations'))
                {
                    $this->loadMigrationsFrom($this->getDir($module) . '/Database/Migrations');
                }

                //Подгружаем переводы
                if(is_dir($this->getDir($module) . '/Resources/Lang'))
                {
                    $this->loadTranslationsFrom($this->getDir($module) . '/Resources/Lang', $module);
                }
                //конфиги
                if(is_dir($this->getDir($module) . '/Config'))
                {
                    $files = array_diff(scandir($this->getDir($module) . '/Config'), array('.','..'));
                    if (empty($files)){
                        return false;
                    }
                    else {
                        foreach ($files as $file)
                        {
                            $this->mergeConfigFrom($this->getDir($module) . '/Config/'. $file, $module . '.' . basename($file, '.php'));
                        }
                    }
                }
            }
        }
    }

    public function register() {

    }
}