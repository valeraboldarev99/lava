@extends('AdminPanel::layouts.app')

@section('title')
    <h1><a href="{{route('admin.manual')}}">Комманды</a></h1>
@endsection

@section('content')
    <h2>Комманды CRM-системы</h2>
    <ul>
        <li><a href="#create_module">Создание модуля</a></li>
        <li><a href="#clear_all">Очистить все(кэш, роуты, сессии ...)</a></li>

        <h3 id="create_module">Создание модуля</h3>
        <pre>
<code>
php artisan module:create {module_name}
</code>
        </pre>
        <h3 id="clear_all">Очистить все(кэш, роуты, сессии ...)</h3>
        <pre>
<code>
php artisan clear:all
</code>
        </pre>
        <p>Включает в себя комманды:</p>
        <pre>
<code>
php artisan cache:clear 
php artisan route:clear 
php artisan view:clear 
php artisan config:clear
</code>
        </pre>
    </ul>
@endsection