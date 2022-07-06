@extends('AdminPanel::admin.index')

@section('title')
	<h2>Пользователи</h2>
@endsection

@section('th')
    <th>@sortablelink('name', trans('AdminPanel::fields.name'))</th>
    <th>@sortablelink('email', trans('AdminPanel::fields.email'))</th>
    <th>@sortablelink('role', trans('Users::adminpanel.role'))</th>
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
            <td>
                {{ $entity->role_name }}
            </td>
            <td class="controls">
                @include('AdminPanel::controls.edit')
                @include('AdminPanel::controls.destroy')
            </td>
        </tr>
    @endforeach
@endsection