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

        <p>Создаст структуру модуля:</p>
        <pre>
            <code>
Module_name
----Config
--------settings.php
----Database 
--------Migrations
------------Date('Y_m_d_hms') . '_create_' . $model_name . '_table.php' 
--------Seeds
------------ucfirst($model_name) . 'TableSeeder.php' 
----Http 
--------Controllers 
------------Admin
----------------IndexController.php
------------IndexController.php 
--------ViewComposers
------------MainComposer.php 
----Models
--------ucfirst($model_name . '.php') 
----Resources 
--------Lang  
------------ru 
----------------adminpanel.php 
----------------index.php 
------------en 
----------------index.php
--------Views 
------------admin
------------  index.blade.php 
----------------form.blade.php
------------index.blade.php
------------main.blade.php
----Routes
--------web.php 
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