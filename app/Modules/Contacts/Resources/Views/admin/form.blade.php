@extends('AdminPanel::admin.form')

@section('title')
    <h2>{{ __('News::adminpanel.title') }}</h2>
@endsection

@section('content')
    <div class="panel-body">
        <div class="col-md-6">
            <label>@lang('AdminPanel::fields.date')</label>
            <p>{{ $entity->datetime }}</p>
        </div>

        <div class="col-md-6">
            <label>IP</label>
            <p>{{ long2ip($entity->ip) }}</p>
        </div>

        <div class="col-md-6">
            <label>@lang('Contacts::index.name')</label>
            <p>{{ $entity->name }}</p>
        </div>

        <div class="col-md-6">
            <label>@lang('Contacts::index.email')</label>
            <p>{{ $entity->email }}</p>
        </div>

        <div class="col-md-6">
            <label>@lang('Contacts::index.phone')</label>
            <p>{{ $entity->phone }}</p>
        </div>

        <div class="col-md-12">
            <label>@lang('Contacts::index.message')</label>
            <p>{!! nl2br($entity->message) !!}</p>
        </div>
    </div>
@endsection