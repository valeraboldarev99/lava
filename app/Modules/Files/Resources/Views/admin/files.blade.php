@extends('AdminPanel::layouts.app')

@section('title')
	<h2>{{ __('Files::adminpanel.files') }}</h2>
@endsection

@section('content')
	<iframe src="/laravel-filemanager?type=Files" style="width: 100%; height: 100vh; overflow: hidden; border: none;"></iframe>
@endsection
