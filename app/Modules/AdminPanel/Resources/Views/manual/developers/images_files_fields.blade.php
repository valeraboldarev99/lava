@extends('AdminPanel::layouts.app')

@section('title')
    <h1><a href="{{route('admin.manual')}}">Поля выбора файла/изображения с сервера</a></h1>
@endsection

@section('content')
    <h2>Выбор файла/изображения с сервера</h2>

    <p>Поле выбора изображения на сервере:</p>
    <pre>
        <code>
            &#64;include('AdminPanel::common.forms.choose_image_from_server', [
                'field_name'    => 'field_name',
                'label'         => 'Images',
                'helptext'      => trans('AdminPanel::fields.help_for_browsefile'),
                'value'         => $entity->field,
            ])
        </code>
    </pre>
    <p>Поле выбора файла на сервере:</p>
    <pre>
        <code>
            &#64;include('AdminPanel::common.forms.choose_file_from_server', [
                'field_name'    => 'field_namer',
                'label'         => 'Files',
                'helptext'      => trans('AdminPanel::fields.help_for_browsefile'),
                'value'         => $entity->field,
            ])
        </code>
    </pre>
@endsection