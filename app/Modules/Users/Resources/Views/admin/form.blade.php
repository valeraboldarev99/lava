@extends('AdminPanel::admin.form')

@section('title')
	<h2>Создать пользователя</h2>
@endsection

@section('form_content')
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label for="name">Имя</label>
                    <input type="text" name="name" class="form-control" value="{{ adminform_value($entity, $entity->name) }}">
                    <span class="glyphicon form-control-feedback"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" class="form-control" value="{{ adminform_value($entity, $entity->email) }}">
                    <span class="glyphicon form-control-feedback"></span>
                </div>
            </div>
        </div>
    </div>
@endsection