<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/adminpanel/css/bootstrap.min.css">
    <link rel="stylesheet" href="/adminpanel/css/style.css">
    <link rel="stylesheet" href="/adminpanel/css/media.css">
</head>
<body>
    <div class="auth_page">
        <div class="wrapper">
            @yield('content')
        </div>
    </div>
</body>
</html>