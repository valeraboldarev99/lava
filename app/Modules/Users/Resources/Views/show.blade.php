@extends('layouts.wide')

@section('content')
	<div class="users__block">
		<h1>Профиль</h1>
		<div>Имя: {{ $entity->name }}</div>
		<div>E-mail: {{ $entity->email }}</div>
		@if($checkUserId)
			<div>Статус: {{ $entity->role }}</div>
			<br>
			<a href="{{ route('users.edit', $entity->id) }}" class="btn btn-primary">Редактировать данные</a>
		@endif
	</div>
@endsection