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

    @if(isset($entity))
        <form method="POST" action="{{ route($routePrefix . 'update', $entity->id) }}">
            @method('PATCH')
    @else
        <form method="POST" action="{{ route($routePrefix . 'store', $entity->id) }}">
    @endif
            @csrf

            @yield('form_content')

            <div class="box-footer">
                <button type="submit" class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
@endsection