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
@endsection