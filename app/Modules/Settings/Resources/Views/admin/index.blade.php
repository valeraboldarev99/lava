@extends('AdminPanel::admin.index')

@section('title')
	<h2>Настройки</h2>
@endsection

@section('th')
    <th>@sortablelink('name', 'Имя')</th>
    <th>@sortablelink('email', 'Slug')</th>
    <th>Управление</th>
@endsection

@section('td')
    @foreach ($entities as $entity)
        <tr>
            <td>
                {{ $entity->name }}
            </td>
            <td>
                {{ $entity->slug }}
            </td>
            <td class="controls">
               @include('AdminPanel::controls.entity_all')
            </td>
        </tr>
    @endforeach
@endsection