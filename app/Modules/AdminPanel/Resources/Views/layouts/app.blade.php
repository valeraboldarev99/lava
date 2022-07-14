<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{asset('adminpanel/bower_components/font-awesome/css/font-awesome.min.css')}}">

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

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="/adminpanel/js/app.js"></script>
    @stack('js')
    @yield('js')
</body>
</html>