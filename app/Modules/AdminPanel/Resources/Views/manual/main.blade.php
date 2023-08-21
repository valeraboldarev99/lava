@extends('AdminPanel::layouts.app')

@section('title')
    <h2>Документация</h2>
@endsection



@section('content')
    @include('AdminPanel::common.errors')

    <h3>
        <a href="#">Для пользователей</a>
    </h3>
    <h3>
        <a href="#">Для разработчиков</a>
    </h3>
    <ul>
        <li><a href="{{ route(config('cms.admin_prefix') . 'manual.show', ['type' => 'developers','name' => 'commands']) }}">Комманды</a></li>
        <li><a href="{{ route(config('cms.admin_prefix') . 'manual.show', ['type' => 'developers','name' => 'add_images']) }}">Добавление загрузки изображений и файлов в модуль</a></li>
        <li><a href="{{ route(config('cms.admin_prefix') . 'manual.show', ['type' => 'developers','name' => 'positions']) }}">Добавление позиционирования записей в модуль</a></li>
    </ul>
@endsection