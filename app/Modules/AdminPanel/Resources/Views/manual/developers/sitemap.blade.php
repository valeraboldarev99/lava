@extends('AdminPanel::layouts.app')

@section('title')
    <h1><a href="{{route('admin.manual')}}">Добавление sitemap в модуль</a></h1>
@endsection

@section('content')
    <h2>Добавление индексирования сущностей модуля в sitemap</h2>
    
    <p>Для того чтобы добавить индексирование модуля в Sitemap, в папку модуля необходимо добавить Facades/Sitemap.php</p>
    <p>Содержание файла по умолчанию:</p>
    <pre>
        <code>
            &lt;?php

            namespace App\Modules\YourModel\Facades;

            use App\Modules\Sitemap\Models\Sitemap as MainSitemap;

            class Sitemap extends MainSitemap
            {
                //
            }

        </code>
    </pre>
    <p>При необходимости можно переопределить параметры эти и другие параметры:</p>
    <pre>
        <code>
            protected $module;                      //Название папки модуля.

            protected $model;                       //Название класса модели.

            protected $route;                       //Название роута.

            // Параметры по умолчанию.
            protected $defaultParams = [
                'changefreq' => 'daily',
                'priority'   => '0.8'
            ];
        </code>
    </pre>
@endsection