@extends('AdminPanel::admin.form')

@section('title')
    <h2>{{ __('News::adminpanel.title') }}</h2>
@endsection

@section('form_content')
    {!! MyForm::open([
        'entity' => $entity,
        'method' => 'POST',
        'store' => $routePrefix . 'store',
        'update' => $routePrefix . 'update',
        'autocomplete' => true,
        'files' => true]) !!}

        <div class="row">
            <div class="col-md-6">
                {!! MyForm::text('title', trans('AdminPanel::fields.title') , $entity->title) !!}
            </div>

            <div class="col-md-4">
                {!! MyForm::date('date', trans('AdminPanel::fields.date') , $entity->date ) !!}
            </div>

            <div class="col-md-2">
                {!! MyForm::checkbox('active', trans('AdminPanel::fields.active'), $entity->active) !!}
            </div>
            <div class="clearfix"></div>

            <div class="col-md-6">
                @include('AdminPanel::common.forms.image', [
                    'field' => 'image',
                    'label' => trans('AdminPanel::fields.image'),
                    'helptext' => trans('AdminPanel::fields.optimal_image_size', ['w' => 1920, 'h' => 780]),
                    'show_img_size' => 'big',
                ])
            </div>

            <div class="col-md-6">
                @include('AdminPanel::common.forms.image', [
                    'field' => 'bg',
                    'label' => trans('AdminPanel::fields.bg_image'),
                    'helptext' => trans('AdminPanel::fields.optimal_image_size', ['w' => 1920, 'h' => 780]),
                    'show_img_size' => 'big',
                    'accept' => ['accept="image/*"'],
                ])
            </div>

            <div class="clearfix"></div>

            <div class="col-md-6">
                @include('AdminPanel::common.forms.file', [
                    'field' => 'file',
                    'field_name' => 'file_name',
                    'label' => trans('AdminPanel::fields.file'),
                    'helptext' => trans('AdminPanel::fields.file_format', ['formats' => 'docx/doc']),
                ])
            </div>
            <div class="clearfix"></div>


            <div class="col-md-12">
                {!! MyForm::textarea('content', trans('AdminPanel::fields.content'), $entity->content, ['rows="8"']) !!}
            </div>

            <div class="col-md-12">
                @include('AdminPanel::common.forms.files.files', [
                    'field' => 'multi_files',
                    'label' => trans('AdminPanel::fields.multiupload_files'),
                    'helptext' =>  trans('AdminPanel::fields.file_format', ['formats' => 'docx/doc']),
                ])
            </div>

            <div class="col-md-12">
                @include('AdminPanel::common.forms.images.images', [
                    'field' => 'multi_images',
                    'label' => trans('AdminPanel::fields.multiupload_images'),
                    'helptext' => trans('AdminPanel::fields.optimal_image_size', ['w' => 500, 'h' => 200]),
                    'show_img_size' => NULL,
                ])
            </div>
        </div>
@endsection
