@extends('AdminPanel::admin.form')

@section('title')
	<h2>Создать пользователя</h2>
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
                {!! MyForm::text('name', trans('AdminPanel::fields.name'), $entity->name) !!}
            </div>
            <div class="col-md-6">
                {!! MyForm::text('email', trans('AdminPanel::fields.email'), $entity->email) !!}
            </div>
            <div class="col-md-6">
                {!! MyForm::password('password', trans('AdminPanel::fields.password'), '', 
                            [ $entity->id ? 'placeholder="' . trans('Users::adminpanel.want_change_pass') . '"' : '']) !!}
            </div>
            <div class="col-md-6">
                {!! MyForm::select('role', trans('Users::adminpanel.role'), $roles) !!}
            </div>

            <div class="col-md-6">
                {!! MyForm::simpleText($entity->last_online_at, trans('Users::adminpanel.last_online_at')) !!}
            </div>

            <div class="col-md-6">
                {!! MyForm::simpleText($entity->last_login_ip, trans('Users::adminpanel.last_login_ip')) !!}
            </div>
        </div>
@endsection