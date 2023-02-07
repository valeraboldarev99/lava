@extends('AdminPanel::admin.index')

@section('title')
    <h2>{{ __('Products::adminpanel.products_categories_title') }}</h2>
@endsection

@section('th')
    <th>@sortablelink('title', 'Имя')</th>
    <th width="120">{{ __('AdminPanel::fields.image') }}</th>
    <th>{{ __('AdminPanel::adminpanel.controls') }}</th>
@endsection

@section('td')
    @foreach ($entities as $entity)
        <tr {!! $entity->active == 1 ?: 'style="background:#f2dede;"' !!}>
            <td>
                {{ $entity->title }}
            </td>
            <td>
                <img src="{{ $entity->getImagePath('category_image', 'middle') }}" alt="{{ $entity->title }}">
            </td>
            <td class="controls">
               @include('AdminPanel::controls.entity_all')
            </td>
        </tr>
    @endforeach
@endsection
