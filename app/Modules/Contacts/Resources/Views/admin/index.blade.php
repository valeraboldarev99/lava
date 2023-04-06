@extends('AdminPanel::admin.index')

@section('title')
    <h2>{{ __('News::adminpanel.title') }}</h2>
@endsection

@section('topmenu')
    <div class="header-controls">
        @include('AdminPanel::controls.main_buttons')
    </div>
    @include('AdminPanel::common.localization')
@endsection

@section('filters')
    <div class="filter__block">
        {!! MyForm::open([
            'action' => 'admin.settings.short_store',
            'method' => 'POST',
            'files' => false]) !!}

            <div class="row">
                {!! MyForm::hidden('name', 'Emails для обратной связи') !!}
                {!! MyForm::hidden('slug', 'contacts.emails') !!}

                <div class="col-md-8">
                    {!! MyForm::text('content', trans('Contacts::adminpanel.contacts_email'), getSetting('contacts.emails')) !!}
                    {!! MyForm::helpText(trans('Contacts::adminpanel.emails_helper')) !!}
                </div>

                <div class="col-md-2 mt_25">
                    {!! MyForm::submit(trans('AdminPanel::adminpanel.buttons.save')) !!}
                </div>
            </div>

        {!! MyForm::close() !!}
    </div>
@endsection

@section('th')
    <th>@sortablelink('datetime', trans('AdminPanel::fields.date'))</th>
    <th>@sortablelink('email', trans('AdminPanel::fields.email'))</th>
    <th>@sortablelink('name', trans('AdminPanel::fields.name'))</th>
    <th>{{ __('AdminPanel::fields.message') }}</th>
    <th>{{ __('AdminPanel::adminpanel.controls') }}</th>
@endsection

@section('td')
    @foreach ($entities as $entity)
        <tr>
            <td>{{ $entity->created_at }}</td>
            <td>{{ $entity->email }}</td>
            <td>{{ $entity->name }}</td>
            <td>{!! nl2br($entity->message) !!}</td>
            <td class="controls">
               	@include('AdminPanel::controls.edit')
	            @include('AdminPanel::controls.destroy')
                {{-- @include('AdminPanel::common.controls.look', ['routePrefix' => $routePrefix, 'id' => $entity->id]) --}}
                {{-- @include('AdminPanel::common.controls.destroy', ['routePrefix' => $routePrefix, 'id' => $entity->id]) --}}
            </td>
        </tr>
    @endforeach
@endsection
