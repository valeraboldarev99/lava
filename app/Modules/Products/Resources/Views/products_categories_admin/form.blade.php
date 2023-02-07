@extends('AdminPanel::admin.form')

@section('title')
    <h2>{{ __('Products::adminpanel.products_categories_title') }}</h2>
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

            <div class="col-md-2">

                {!! MyForm::checkbox('active', trans('AdminPanel::fields.active'), $entity->active) !!}
            </div>
            <div class="clearfix"></div>

            <div class="col-md-6">
                @include('AdminPanel::common.forms.image', [
                    'field' => 'category_image',
                    'label' => trans('AdminPanel::fields.image'),
                    'helptext' => trans('AdminPanel::fields.optimal_image_size', ['w' => 1920, 'h' => 780]),
                    'show_img_size' => 'big',
                ])
            </div>

            <div class="col-md-6">
                @include('AdminPanel::common.forms.image', [
                    'field' => 'category_bg',
                    'label' => trans('AdminPanel::fields.bg_image'),
                    'helptext' => trans('AdminPanel::fields.optimal_image_size', ['w' => 1920, 'h' => 780]),
                ])
            </div>

            <div class="clearfix"></div>

            <div class="col-md-6">
                @include('AdminPanel::common.forms.file', [
                    'field' => 'category_file',
                    'field_name' => 'category_file_name',
                    'label' => trans('AdminPanel::fields.file'),
                    'helptext' => trans('AdminPanel::fields.file_format', ['formats' => 'docx/doc']),
                ])
            </div>

            <div class="col-md-6">
                @include('AdminPanel::common.forms.file', [
                    'field' => 'category_file2',
                    'field_name' => 'category_file_name2',
                    'label' => 'category_file2',
                    'helptext' => trans('AdminPanel::fields.file_format', ['formats' => 'docx/doc']),
                ])
            </div>
        </div>
@endsection
