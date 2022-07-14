@extends('layouts.wide')

@section('content')
    <div class="auth__content">
        <h1 style="text-align: center;">@lang('Users::index.login')</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form__item">
                {!! MyForm::email('email', trans('Users::index.e-mail'), old('email')) !!}
            </div>
            <div class="form__item">
                {!! MyForm::password('password', trans('Users::index.password')) !!}
            </div>
            <div class="form__item">
                {!! MyForm::button('submit',trans('Users::index.submit'), ['class="btn btn-primary"']) !!}
            </div>
        {!! MyForm::close() !!}
    </div>
@endsection