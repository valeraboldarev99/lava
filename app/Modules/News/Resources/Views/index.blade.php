@extends('layouts.wide')

@section('content')
	<div class="wrapper">
        <div class="contacts__info">
            {!! $page->content !!}
        </div>
        @foreach($items as $item)
            <a href="{{ route('news.show', ['id', $item->id]) }}">{{ $item->title }}</a>
            <br>
        @endforeach
    </div>
@endsection