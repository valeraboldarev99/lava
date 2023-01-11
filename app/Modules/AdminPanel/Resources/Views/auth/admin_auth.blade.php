@extends('AdminPanel::layouts.app_auth')

@section('content')
<div class="auth-container">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form__item">
            <label for="email" class="auth-label">{{__('AdminPanel::auth.email')}}</label>
            <input id="email" type="email" class="auth-input" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @if ($errors->has('email'))
                <div class="form-error text-danger" style="margin-left: 21%;">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <div class="form__item">
            <label for="password" class="auth-label">{{__('AdminPanel::auth.password')}}</label>
            <input id="password" type="password" class="auth-input" name="password" required autocomplete="current-password">
            @if ($errors->has('password'))
                <div class="form-error text-danger" style="margin-left: 21%;">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>

        <div class="form__item">
            <button type="submit" class="btn btn-primary auth-btn">{{__('AdminPanel::auth.login')}}</button>
        </div>
    </form>
</div>
@endsection