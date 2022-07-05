@extends('AdminPanel::layouts.app')

@section('title')
    <h2>title</h2>
@endsection

@section('topmenu')
    @include('AdminPanel::controls.header_all')
@endsection

@section('content')
    <div class="panel-body">
        @include('AdminPanel::common.errors')

            @yield('form_content')

            <div class="box-footer">
                 {!! MyForm::submit(trans('AdminPanel::fields.save')) !!}
            </div>

        {!! MyForm::close() !!}
    </div>
@endsection