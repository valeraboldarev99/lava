@extends('AdminPanel::layouts.app')

@section('title')
    <h2>{{ __('Backuper::adminpanel.title') }}</h2>
@endsection

@section('content')
    @include('AdminPanel::common.errors')

    <h3>{{ __('Backuper::adminpanel.files') }}</h3>
    <div>
        {!! MyForm::open([
            'action' => route($routePrefix . 'backupUploads'),
            'method' => 'POST',
            'files' => false]) !!}
        
            <div class="row">
                <div class="col-md-2">
                    {!! MyForm::date(
                        'date_from',
                        trans('Backuper::adminpanel.date_from'),
                        date('Y-m-d', strtotime('-1 month'))
                    ) !!}
                </div>

                <div class="col-md-2">
                    {!! MyForm::date(
                        'date_to', 
                        trans('Backuper::adminpanel.date_to'),
                        date('Y-m-d'),
                        ['max="' . date('Y-m-d') . '"']
                    ) !!}
                </div>

                <div class="col-md-2">
                    {!! MyForm::checkbox('all_time', trans('Backuper::adminpanel.all_time')) !!}
                </div>

                <div class="col-md-3">
                    {!! MyForm::select('folder', trans('Backuper::adminpanel.folder'), $folders) !!}
                </div>

                <div class="col-md-3 mt_25 ipad_mt_33 mob_mt_20">
                    {!! MyForm::submit(trans('Backuper::adminpanel.buttons.start')) !!}
                </div>
            </div>

        {!! MyForm::close() !!}
    </div>
    <div>
        @include('Backuper::admin.entities', [
            'entities' => $files_entities,
            'type' => 'files',
        ])
    </div>

    <hr>

    <h3>{{ __('Backuper::adminpanel.database') }}</h3>
    <div>
        {!! MyForm::open([
            'action' => route($routePrefix . 'backupDataBase'),
            'method' => 'POST',
            'files' => false]) !!}
        
            <div class="row">
                <div class="col-md-3">
                    {!! MyForm::submit(trans('Backuper::adminpanel.buttons.start')) !!}
                </div>
            </div>

        {!! MyForm::close() !!}
    </div>
    <div>
        @include('Backuper::admin.entities', [
            'entities' => $db_entities,
            'type' => 'database',
        ])
    </div>
@endsection
