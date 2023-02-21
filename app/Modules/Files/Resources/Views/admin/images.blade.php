@extends('AdminPanel::layouts.app')

@section('title')
	<h2>{{ __('Files::adminpanel.images') }}</h2>
@endsection

@section('content')
	<iframe src="/laravel-filemanager?type=Images" style="width: 100%; height: 100vh; overflow: hidden; border: none;"></iframe>
@endsection
