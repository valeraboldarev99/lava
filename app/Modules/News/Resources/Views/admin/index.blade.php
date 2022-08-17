@extends('AdminPanel::admin.index')

@section('title')
    <h2>{{ __('News:adminpanel.title') }}</h2>
@endsection

@section('th')
    <th>@sortablelink('title', 'Имя')</th>
    <th>Управление</th>
@endsection

@section('td')
    @foreach ($entities as $entity)
        <tr {!! $entity->active == 1 ?: 'style="background:#f2dede;"' !!}>
            <td>
                {{ $entity->title }}
            </td>
            <td class="controls">
               @include('AdminPanel::controls.entity_all')
            </td>
        </tr>
    @endforeach
@endsection
