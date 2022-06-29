@extends('AdminPanel::admin.index')

@section('title')
	<h2>Пользователи</h2>
@endsection

@section('th')
    <th>@sortablelink('name', 'Имя')</th>
    <th>@sortablelink('email', 'Email')</th>
    <th width="150">Control</th>
@endsection

@section('td')
    @foreach ($entities as $entity)
        <tr>
            <td>
                {{ $entity->name }}
            </td>
            <td>
                {{ $entity->email }}
            </td>
            <td class="controls">
                @include('AdminPanel::controls.entity_all')
            </td>
        </tr>
    @endforeach
@endsection