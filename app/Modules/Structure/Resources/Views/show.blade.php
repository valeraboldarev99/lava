@extends('layouts.wide')

@section('content')
	<h1>{{ $page->title }}</h1>
    {!! $page->content !!}
@endsection