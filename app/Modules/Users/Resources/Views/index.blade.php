@extends('layouts.wide')

@section('content')
	<div class="users__block">
	{!! $page->content !!}
		<div class="users">
			<div class="user user__header">
				<div class="user__item">ID</div>
				<div class="user__item">Name</div>
				<div class="user__item">E-mail</div>
			</div>
			@foreach($items as $user)
				<div class="user">
					<div class="user__item">{{ $user->id }}</div>
					<div class="user__item">{{ $user->name }}</div>
					<div class="user__item">{{ $user->email }}</div>
					<a href="{{ route('users.show', $user->id) }}" class="mask"></a>
				</div>
			@endforeach
		</div>
	</div>
@endsection