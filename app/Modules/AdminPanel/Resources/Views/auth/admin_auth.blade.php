@extends('AdminPanel::layouts.app_auth')

@section('content')
<div class="auth-container">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form__item">
            <label for="email" class="auth-label">@lang('AdminPanel::auth.email')</label>
            <input id="email" type="email" class="auth-input" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        </div>

        <div class="form__item">
            <label for="password" class="auth-label">@lang('AdminPanel::auth.password')</label>
            <input id="password" type="password" class="auth-input" name="password" required autocomplete="current-password">
        </div>

        <div class="form__item">
            <button type="submit" class="btn btn-primary auth-btn">@lang('AdminPanel::auth.login')</button>
        </div>
    </form>
</div>
@endsection