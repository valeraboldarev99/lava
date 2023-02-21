@extends('layouts.wide')

@section('content')
    <div class="auth__content">
        <h1 style="text-align: center;">{{__('Users::index.register')}}</h1>
        <p style="text-align: center;  margin: 25px 0;">
             <a href="{{ route('login') }}" class="btn btn-primary">{{__('Users::index.login')}}</a>
             <a href="{{ route('registerForm') }}" class="btn btn-primary">{{__('Users::index.register')}}</a>
         </p>
        @if(session()->has('message'))
            <div class="message__block">{{ session('message') }}</div>
        @else
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form__item">
                    {!! MyForm::text('name', trans('Users::index.name'), old('name')) !!}
                </div>
                <div class="form__item">
                    {!! MyForm::email('email', trans('Users::index.e-mail'), old('email')) !!}
                </div>
                <div class="form__item">
                    {!! MyForm::password('password', trans('Users::index.password')) !!}
                </div>
                <div class="form__item">
                    {!! MyForm::password('password_confirmation', trans('Users::index.password_confirmation')) !!}
                </div>
                <div class="form__item">
                    {!! MyForm::button('submit',trans('Users::index.submit'), ['class="btn btn-primary"']) !!}
                </div>
            {!! MyForm::close() !!}
        @endif
    </div>
@endsection