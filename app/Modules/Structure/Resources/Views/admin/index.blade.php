@extends('AdminPanel::admin.index')

@section('title')
	<h2>Структура сайта</h2>
@endsection

@section('th')
    <th>@sortablelink('name', 'Имя')</th>
    <th>@sortablelink('email', 'Slug')</th>
    <th>Управление</th>
@endsection

@section('td')
    @foreach ($entities as $entity)
        <tr {!! $entity->active == 1 ?: 'style="background:#f2dede;"' !!}>
            <td>
                {{ $entity->title }}
            </td>
            <td>
                {{ $entity->slug }}
            </td>
            <td class="controls">
               @include('AdminPanel::controls.entity_all')
            </td>
        </tr>
        @foreach($entity->children as $child)
            <tr>
                <td>—{{ $child->title }}</td>
                <td>{{ $child->slug }}</td>
                <td class="controls">
                   @include('AdminPanel::controls.entity_all', ['entity' => $child])
                </td>
            </tr>
        @endforeach
    @endforeach
@endsection