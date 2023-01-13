@extends('AdminPanel::layouts.app')

@section('title')
    <h2>title</h2>
@endsection

@section('topmenu')
    @include('AdminPanel::controls.header_all')
@endsection

@section('form_js')
    @include('AdminPanel::common.forms.ckeditor', [
        'fields' => ['content']
    ])
@endsection

@section('content')
    <div class="panel-body">
        @include('AdminPanel::common.errors')

            @yield('form_content')

            <div class="box-footer">
                 {!! MyForm::submit(trans('AdminPanel::adminpanel.buttons.save')) !!}
            </div>

        {!! MyForm::close() !!}
    </div>
@endsection