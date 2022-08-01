@extends('layouts.app')

@section('page_content')
    <h2>Главная</h2>
    {!! getSetting('about.lava') !!}
    <br>
    {!! $page->content !!}
@endsection