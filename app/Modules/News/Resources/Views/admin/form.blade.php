@extends('AdminPanel::admin.form')

@section('title')
    <h2>Module_title</h2>
@endsection

@section('topmenu')
    @include('AdminPanel::controls.header_all')
@endsection

@section('form_content')
    {!! MyForm::open([
        'entity' => $entity,
        'method' => 'POST',
        'store' => $routePrefix . 'store',
        'update' => $routePrefix . 'update',
        'autocomplete' => true]) !!}

        <div class="row">
            <div class="col-md-6">
                {!! MyForm::text('title', trans('AdminPanel::fields.title') , $entity->title) !!}
            </div>

            <div class="col-md-2">

                {!! MyForm::checkbox('active', trans('AdminPanel::fields.active'), $entity->active) !!}
            </div>
            <div class="clearfix"></div>

            <div class="col-md-12">
                {!! MyForm::textarea('content', trans('AdminPanel::fields.content'), $entity->content, ['rows="8"']) !!}
            </div>
        </div>
@endsection
