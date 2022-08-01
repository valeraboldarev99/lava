<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/adminpanel/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/adminpanel/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/adminpanel/favicons/favicon-16x16.png">
    <link rel="manifest" href="/adminpanel/favicons/site.webmanifest">
    <link rel="mask-icon" href="/adminpanel/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

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
