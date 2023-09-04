@extends('AdminPanel::layouts.app')

@section('content')
	Welcome to admin panel
    <a href="{{ route(config('cms.admin_prefix') . 'manual') }}" class="manual__link">Документация по ипользованию Админ панели</a>
@endsection