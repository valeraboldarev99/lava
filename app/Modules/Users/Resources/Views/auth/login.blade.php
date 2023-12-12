@extends('layouts.inner')

@section('content')
    <div class="auth__content">
        <h1 style="text-align: center; margin-bottom: 25px;">{{__('Users::index.login')}}</h1>

       <p style="text-align: center;">
            <a href="{{ route('login') }}" class="btn btn-primary">{{__('Users::index.login')}}</a>
            <a href="{{ route('registerForm') }}" class="btn btn-primary">{{__('Users::index.register')}}</a>
        </p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form__item">
                {!! MyForm::email('email', trans('Users::index.e-mail'), old('email')) !!}
            </div>
            <div class="form__item">
                {!! MyForm::password('password', trans('Users::index.password')) !!}
            </div>
            @if (Route::has('password.request'))
                <div class="form__item">
                    <a href="{{ route('password.request') }}" style="text-decoration: none;">
                        {{__('Users::index.forgotPass')}}
                    </a>
                </div>
            @endif
            <div class="form__item">
                {!! MyForm::button('submit',trans('Users::index.submit'), ['class="btn btn-primary"']) !!}
            </div>
        {!! MyForm::close() !!}
    </div>
@endsection