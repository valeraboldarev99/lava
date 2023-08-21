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
        <li><a href="{{ route(config('cms.admin_prefix') . 'manual.show', ['type' => 'developers','name' => 'add_images']) }}">Как добавить изображения и файлы в модуль</a></li>
        {{-- <li><a href="{{ route(config('cms.admin_prefix') . 'manual.show', ['type' => 'developers','name' => '1']) }}">Для разработчиков - 2</a></li>
        <li><a href="{{ route(config('cms.admin_prefix') . 'manual.show', ['type' => 'developers','name' => '1']) }}">Для разработчиков - 3</a></li>
        <li><a href="{{ route(config('cms.admin_prefix') . 'manual.show', ['type' => 'developers','name' => '1']) }}">Для разработчиков - 4</a></li>
        <li><a href="{{ route(config('cms.admin_prefix') . 'manual.show', ['type' => 'developers','name' => '1']) }}">Для разработчиков - 5</a></li>
        <li><a href="{{ route(config('cms.admin_prefix') . 'manual.show', ['type' => 'developers','name' => '1']) }}">Для разработчиков - 6</a></li> --}}
    </ul>
@endsection