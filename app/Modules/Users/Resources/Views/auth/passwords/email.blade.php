@extends('layouts.wide')

@section('content')
    @include('AdminPanel::common.errors')

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form__item">
            {!! MyForm::email('email', trans('Users::index.e-mail'), old('email')) !!}
        </div>
        <div class="form__item">
            {!! MyForm::button('submit',trans('Users::index.send'), ['class="btn btn-primary"']) !!}
        </div>
    {!! MyForm::close() !!}
@endsection