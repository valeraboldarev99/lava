@extends('AdminPanel::layouts.app')

@section('title')
    <h1><a href="{{route('admin.manual')}}">Настройки редактора ckeditor</a></h1>
@endsection

@section('content')
    <h2>Визуальный редактор ckeditor</h2>
    <p>По умолчанию для ckeditor определено поле 'content'</p>
    <p>Другие поля можно добавить в <code>app/Modules/AdminPanel/Resources/Views/admin/form.blade.php</code></p>
    <pre>
        <code>
            &#64;section('form_js')
                &#64;include('AdminPanel::common.forms.ckeditor', [
                    'fields' => ['content']                             //тут добавить новые поля
                ])
            &#64;endsection
        </code>
    </pre>
    <p>В форме прописать:</p>
        <pre>
        <code>
            &#123;!! MyForm::textarea('content', trans('AdminPanel::fields.content'), $entity->content, ['rows="8"']) !!&#125;
        </code>
    </pre>
    <p>Плагин ckeditor расположен: <code>public/adminpanel/bower_components/ckeditor4</code></p>
@endsection