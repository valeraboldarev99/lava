@extends('AdminPanel::admin.index')

@section('title')
	<h2>Настройки</h2>
@endsection

@section('th')
    <th>@sortablelink('name', 'Имя')</th>
    <th>@sortablelink('email', 'Slug')</th>
    <th>Control</th>
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
            <td>
               @include('AdminPanel::controls.edit')
               @include('AdminPanel::controls.destroy')
            </td>
        </tr>
    @endforeach
@endsection