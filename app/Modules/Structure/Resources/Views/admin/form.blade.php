@extends('AdminPanel::admin.form')

@section('title')
	<h2>Структура сайта</h2>
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
                {!! MyForm::text('title', trans('AdminPanel::fields.name') , $entity->title) !!}
            </div>

            @if($entity->depth == 0)
                <div class="col-md-6">
                    {!! MyForm::hidden('template', 'index') !!}
                </div>
            @endif

            @if(!$entity->id || $entity->depth != 0)
                <div class="col-md-4">
                    {!! MyForm::text('slug', trans('AdminPanel::fields.slug') , $entity->slug) !!}
                </div>

                <div class="col-md-2">
                    {!! MyForm::checkbox('active', trans('AdminPanel::fields.active'), $entity->active) !!}
                </div>

                <div class="clearfix"></div>

                <div class="col-md-6">
                    {!! MyForm::select('parent_id', trans('Structure::adminpanel.parent'), $parents) !!}
                </div>

                <div class="col-md-4">
                    {!! MyForm::select('module', trans('Structure::adminpanel.module'), $entity->getModules()) !!}
                </div>

                <div class="col-md-2">
                    {!! MyForm::checkbox('redirector', trans('Structure::adminpanel.redirector'), $entity->redirector) !!}
                </div>

                <div class="clearfix"></div>

                <div class="col-md-12" id="js-redirect_url" style="display: none;">
                    {!! MyForm::text('redirect_url', trans('Structure::adminpanel.redirect_url') , $entity->redirect_url) !!}
                </div>

                <div class="clearfix"></div>

                <div class="col-md-6">
                    {!! MyForm::select('template', trans('Structure::adminpanel.template'), $entity->getTemplates()) !!}
                </div>
            @endif

            <div class="clearfix"></div>

            <div class="col-md-12">
                {!! MyForm::textarea('content', trans('AdminPanel::fields.content'), $entity->content, ['rows="8"']) !!}
            </div>
        </div>
@endsection
