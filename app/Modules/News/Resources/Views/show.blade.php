@extends('layouts.wide')

@section('content')
	<div class="wrapper">
        <div class="block__block">
            <h2 class="block__block_header">
                {{ $entity->title }}
            </h2>
            {!! $entity->content !!}
        </div>
    </div>
@endsection