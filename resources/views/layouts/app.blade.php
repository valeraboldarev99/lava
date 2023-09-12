<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta content="telephone=no" name="format-detection" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link href="/css/jquery-3-5-7.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/fonts.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/media.css">
    
    @stack('css')
    @stack('json')
</head>
<body>
    <div class="page">
        @include('common.header')

		<main class="page__main">
            @yield('page_content')
		</main>

        @include('common.footer')
	</div>

    @include('common.sidebar')
    
    <script src="/js/jquery-3-6-4.min.js"></script>
    <script src="/js/jquery-3-5-7.fancybox.js"></script>
    <script src="/js/contact_modal.js"></script>
    <script src="/js/core.js"></script>
    @stack('js')
</body>
</html>
