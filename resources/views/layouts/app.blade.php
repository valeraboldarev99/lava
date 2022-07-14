<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="/css/style.css"/>
    @stack('css')
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
    @stack('js')
</body>
</html>
