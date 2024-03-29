@extends('AdminPanel::admin.index')

@section('title')
    <h2>{{ __('News::adminpanel.title') }}</h2>
@endsection

@section('topmenu')
    <div class="header-controls">
        @include('AdminPanel::controls.main_buttons')
        @include('AdminPanel::common.import_export')
    </div>
    @include('AdminPanel::common.localization')
@endsection

@section('th')
    <th>@sortablelink('title', 'Имя')</th>
    <th width="120">{{ __('AdminPanel::fields.image') }}</th>
    <th width="130">{{ __('AdminPanel::adminpanel.position') }}</th>
    <th>{{ __('AdminPanel::adminpanel.controls') }}</th>
@endsection

@section('td')
    @foreach ($entities as $entity)
        <tr {!! $entity->active == 1 ?: 'style="background:#f2dede;"' !!}>
            <td>
                {{ $entity->title }}
            </td>
            <td>
                <img src="{{ $entity->getImageWebpPath('image', 'middle') }}" alt="{{ $entity->title }}">
            </td>
            <td>
                @include('AdminPanel::controls.position')
            </td>
            <td class="controls">
               @include('AdminPanel::controls.entity_all')
            </td>
        </tr>
    @endforeach
@endsection
