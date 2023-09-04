@extends('AdminPanel::layouts.app')

@section('title')
    <h2>Поиск</h2>
@endsection

@section('content')
    @include('AdminPanel::common.errors')

    @include('Search::admin.search')
    @foreach($results as $result)
        <div><a href="{{ route($result->route_name, $result->id) }}">{{ $result->title }}</a></div>
    @endforeach
@endsection