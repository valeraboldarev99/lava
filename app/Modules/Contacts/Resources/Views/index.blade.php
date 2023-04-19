@extends('layouts.wide')

@section('content')
	<div class="wrapper">
        <div class="contacts__info">
            {!! $page->content !!}
        </div>
        @include('Contacts::header_btn')
        <div class="contacts__form">
            @include('Contacts::form')
        </div>
    </div>
@endsection