@extends('layouts.wide')

@section('content')
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form__item">
            {!! MyForm::email('email', trans('Users::index.e-mail'), $email ?? old('email')) !!}
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
@endsection