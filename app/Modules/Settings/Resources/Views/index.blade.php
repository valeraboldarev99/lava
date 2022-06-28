@extends('layouts.app')

@section('content')
	{{ $user->name }}
	@if($user->isAdmin())
		<a href="{{ route('admin_panel') }}">Перейти в панель управления</a>
	@endif
@endsection