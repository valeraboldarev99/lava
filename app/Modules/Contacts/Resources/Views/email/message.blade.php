<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<?php
$fontFamily = 'font-family: Raleway';
$style = [
    'body' => '
        margin: 0;
        padding: 0; 
        width: 100%; 
        font-family: Raleway, sans-serif;
        font-size: 15px;
        line-height: 21px;
        font-weight: 400;
        color: #373737;',

    'header__logo' => '
        text-align: center;
        margin: 20px auto 15px auto;',

    'mail__content' => '
        margin: 40px auto;',

    'default__text' => '
        font-size: 15px;
        line-height: 21px;
        font-weight: 400;
        margin: 0;
        text-decoration: none;
        color: #27282c;',
    
    'dark__text' => '
        font-weight: 600;
        line-height: 21px;
        margin: 0;',
];
?>

<body style="{{ $style['body'] }}">
    <div style="{{ $style['mail__content'] }}">
        <p style="{{ $style['default__text'] }}">
            <p style="{{ $style['dark__text'] }}">@lang('Contacts::mail.fields.name'):</p>
            {{ $model->name }}
        </p>
        <p style="{{ $style['default__text'] }}" >
            <p style="{{ $style['dark__text'] }}">@lang('Contacts::mail.fields.email'):</p>
            <a href="mailto:{{ $model->email }}">
                {{ $model->email }}
            </a>
        </p>
        <p style="{{ $style['default__text'] }}">
            <p style="{{ $style['dark__text'] }}">@lang('Contacts::mail.fields.phone'):</p>
            <a href="tel:{!! preg_replace('/\D+/', '', $model->phone) !!}">
                {{ $model->phone }}
            </a>
        </p>

        <div>
            <p style="{{ $style['dark__text'] }}">@lang('Contacts::mail.fields.message'):</p>
            <p style="{{ $style['default__text'] }}"> {!! nl2br(strip_tags($model->message)) !!}</p>
        </div>

                

    </div>
</body>
</html>