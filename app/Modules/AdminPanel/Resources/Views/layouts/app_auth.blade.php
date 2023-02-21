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

    <!-- Styles -->
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