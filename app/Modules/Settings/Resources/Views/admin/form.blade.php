@extends('AdminPanel::admin.form')

@section('title')
	<h2>Создать пользователя</h2>
@endsection

@section('form_content')
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label for="name">Наименование</label>
                    <input type="text" name="name" class="form-control" value="{{ adminform_value($entity, $entity->name) }}">
                    <span class="glyphicon form-control-feedback"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label for="slug">Адресное имя</label>
                    <input type="text" name="slug" class="form-control" value="{{ adminform_value($entity, $entity->slug) }}">
                    <span class="glyphicon form-control-feedback"></span>
                </div>
            </div>
        </div>
    </div>
@endsection