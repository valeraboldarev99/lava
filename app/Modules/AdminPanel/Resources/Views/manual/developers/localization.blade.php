@extends('AdminPanel::layouts.app')

@section('title')
    <h1><a href="{{route('admin.manual')}}">Локализация</a></h1>
@endsection

@section('content')
    <h2>Добавление локализации модуля</h2>
    
    <p>Если в системе нет локализации нужно сперва прописать данные в config/localization.php</p>
    <p>Пример:</p>
    <pre>
        <code>
            &lt;?php
            return [
                'locale' => config('app.locale'),                       //main language
                'locales' => ['ru', 'en'],                              //site languages
                'sitemap_locales_priority' => ['ru', 'en'],             //sitemap languages sorted by priority
                'languages' => [
                    'ru' => [
                        'lang'      => 'ru',
                        'name'      => 'Русский',
                    ],
                    'en' => [
                        'lang'      => 'en',
                        'name'      => 'English',
                    ],
                ],
            ];
        </code>
    </pre>
    <p>В вашем модуле в config/setting.php</p>
    <pre>
        <code>
            'localization'      => true,
        </code>
    </pre>

    <p>В вашем модуле в файле миграции, добавить поле для языка</p>
    <pre>
        <code>
            $table->enum('lang', ['ru', 'en']);
        </code>
    </pre>

    <p>В вашем модуле в resourses/lang продублировать папку для нужного языка и внести переводы.</p>
    <p>По умолчанию файл переводов не переводится.</p>
    
    <p>В вашем модуле в routes/web.php добавить группу локализации.</p>
    <pre>
        <code>
            Route::group([
                'prefix' => Localization::locale(),
                'middleware' => 'setLocale'], function() {

                    //пренести роуты сюда
            });
        </code>
    </pre>

    <h3>Функции для локализации</h3>
    <ul>
        <li>getLang() - получить активную локаль</li>
        <li>adminLocale($locale['lang']) - возвращает ссылку для другого языка модуля в админ панели</li>
        <li>checkModelLocalization($model_name) - проверяет активирована ли локализация модуля в config/setting.php</li>
    </ul>
@endsection