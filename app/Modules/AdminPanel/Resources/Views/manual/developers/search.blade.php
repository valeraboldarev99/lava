@extends('AdminPanel::layouts.app')

@section('title')
    <h1><a href="{{route('admin.manual')}}">Поиск по сайту</a></h1>
@endsection

@section('content')
    <h2>Поиск по сайту</h2>
    <p>За функционал поиска по сайту отвечает модуль Search</p>
    <p>Чтобы в необходимом модуле проводился поиск необходимо в этом модуле в <code>config/settings.php</code> добавить код с параметрами поиска</p>
    
    <table border="1" cellpadding="1" cellspacing="1">
        <thead>
            <tr>
                <th scope="col" style="text-align: center;">Параметр</th>
                <th scope="col" style="text-align: center;">Значение</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align:center"><code>&#39;model_path&#39;</code></td>
                <td style="text-align:left">
                <p>Обязательно. Путь до модели.</p>

                <p>Пример: <code>&#39;App\Modules\News\Models\News&#39;</code></p>
                </td>
            </tr>
            <tr>
                <td style="text-align:center"><code>&#39;user_route&#39;</code></td>
                <td style="text-align:left">Необязательно.&nbsp;$routePrefix - для пользователя.</td>
            </tr>
            <tr>
                <td style="text-align:center"><code>&#39;admin_route&#39;</code></td>
                <td style="text-align:left">Необязательно. $routePrefix - для админа.</td>
            </tr>
            <tr>
                <td style="text-align:center"><code>&#39;block_title&#39;</code></td>
                <td style="text-align:left">
                <p>Необязательно. Название блока результатов поиска.&nbsp;</p>

                <p>По умолчанию берется из файлов локализации: <code>...title</code></p>
                </td>
            </tr>
            <tr>
                <td style="text-align:center"><code>&#39;user_search_content_view&#39;</code></td>
                <td style="text-align:left">Необязательно.&nbsp;Путь до view если нужно переопределить вывод результатов для пользователя.</td>
            </tr>
            <tr>
                <td style="text-align:center"><code>&#39;admin_search_content_view&#39;</code></td>
                <td style="text-align:left">Необязательно. Путь до view если нужно переопределить вывод результатов для админа.</td>
            </tr>
            <tr>
                <td style="text-align:center"><code>&#39;admin_search_fields&#39;</code></td>
                <td style="text-align:left">Необязательно. По каким полям разрешать&nbsp;искать админу.&nbsp;</td>
            </tr>
            <tr>
                <td style="text-align:center"><code>&#39;user_search_fields&#39;</code></td>
                <td style="text-align:left">Необязательно. По каким полям разрешать&nbsp;искать пользователю.&nbsp;</td>
            </tr>
            <tr>
                <td style="text-align:center"><code>&#39;sort_by_field&#39;</code></td>
                <td style="text-align:left">Необязательно. Сортировать по полю.</td>
            </tr>
        </tbody>
    </table>

    <p>&nbsp;</p>

    <p>Пример:</p>
    <pre>
        <code>
        &lt;?php

        return [
            // ..
            'search' => [
                [
                    'model_path' => 'App\Modules\News\Models\News',
                    'user_route' => 'news.index',
                    'admin_route' => 'admin.news.',
                    'block_title' => trans('News::index.title'),
                    'user_search_content_view' => 'News::search_content',
                    'admin_search_content_view' => 'News::admin.search_content',
                    'admin_search_fields' => ['title', 'date', 'preview', 'content', 'created_at', 'updated_at'],
                    'user_search_fields' => ['title'],
                    'sort_by_field' => 'position',
                ],
            ],
        ];
        </code>
    </pre>
    
@endsection