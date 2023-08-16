@extends('AdminPanel::admin.index')

@section('title')
    <h2>{{ __('Products::adminpanel.title') }}</h2>
@endsection

@section('th')
    <th>@sortablelink('title', trans('AdminPanel::fields.name'))</th>
    <th>@sortablelink('category_id', trans('Products::adminpanel.category_id'))</th>
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
                {{ $entity->productCategory->title }}
            </td>
            <td>
                <img src="{{ $entity->getImagePath('image', 'middle') }}" alt="{{ $entity->title }}">
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
