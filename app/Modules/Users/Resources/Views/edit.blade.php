@extends('layouts.wide')

@section('content')
	<div class="users__block">
		<div class="auth__content">
		    <h1 style="text-align: center;">{{ __('Users::index.edit') }}</h1>
		    @if(session()->has('message'))
    			<div class="message__block">{{ session('message') }}</div>
		    @else
			    <form method="POST" action="{{ route('users.update', Auth::id()) }}">
			    	@csrf
			    	@method('PATCH')
			        <div class="form__item">
			            {!! MyForm::text('name', trans('Users::index.name'), $entity->name) !!}
			        </div>
			        <div class="form__item">
			            {!! MyForm::email('email', trans('Users::index.e-mail'), $entity->email, ['readonly', 'title="Нельзя изменить email"', 'style="color: #aaa"']) !!}
			        </div>
			        <div class="form__item">
			            {!! MyForm::password('password', trans('Users::index.password')) !!}
			        </div>
			        <div class="form__item">
			            {!! MyForm::password('password_confirmation', trans('Users::index.password_confirmation')) !!}
			        </div>
			        <div class="form__item">
			            {!! MyForm::button('submit', trans('Users::index.send'), ['class="btn btn-primary"']) !!}
			        </div>
			    {!! MyForm::close() !!}
			</div>
		    @endif
	</div>
@endsection