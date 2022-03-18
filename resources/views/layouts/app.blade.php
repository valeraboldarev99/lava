<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css"/>
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
    <div class="page page_inner">
        <div class="page__header">
            <div class="wrapper">
                @include('common.header')
            </div>
        </div>
        <div class="page__main">
            <section class="layout">
                <div class="wrapper">
                    @yield('page_content')
                </div>
            </section>
        </div>
    </div>
</body>
</html>
