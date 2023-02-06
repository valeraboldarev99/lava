<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/adminpanel/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/adminpanel/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/adminpanel/favicons/favicon-16x16.png">
    <link rel="manifest" href="/adminpanel/favicons/site.webmanifest">
    <link rel="mask-icon" href="/adminpanel/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="{{asset('adminpanel/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminpanel/bower_components/select2/dist/css/select2.css')}}">

    <link rel="stylesheet" href="/adminpanel/css/bootstrap.min.css">
    <link rel="stylesheet" href="/adminpanel/css/style.css">
    <link rel="stylesheet" href="/adminpanel/css/theme.css">
    <link rel="stylesheet" href="/adminpanel/css/media.css">
    @stack('css')
    @yield('css')
</head>
<body>
    <div class="admin-panel-page">
        <div class="wrapper">
            @include('AdminPanel::common.header')
            <div class="main">
                @include('AdminPanel::common.sidebar')
                <main class="content-wrapper">
                    <div class="content-header">
                        @yield('title')
                        @yield('topmenu')
                    </div>
                    <div class="content-main">
                        @yield('content')
                    </div>
                </main>
            </div>
            @include('AdminPanel::common.footer')
        </div>
    </div>

    <script src="/adminpanel/js/jquery.js"></script>
    <script src="{{asset('adminpanel/bower_components/select2/dist/js/select2.full.js')}}"></script>
    <script src="/adminpanel/js/app.js"></script>
    @stack('js')
    @yield('js')
</body>
</html>