@extends('AdminPanel::admin.index')

@section('title')
	<h2>Пользователи</h2>
@endsection

@section('th')
    <th>@sortablelink('name', trans('AdminPanel::fields.name'))</th>
    <th>@sortablelink('email', trans('AdminPanel::fields.email'))</th>
    <th>{{ __('Users::adminpanel.role') }}</th>
    <th width="130">@sortablelink('last_online_at', trans('Users::adminpanel.last_online_at'))</th>
    <th width="70">@sortablelink('last_login_ip', 'IP')</th>
    <th width="150">{{ __('AdminPanel::adminpanel.controls') }}</th>
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
                {{ $entity->roles->first()->name }}
            </td>
            <td>
                @if($entity->last_online_at)
                    {{ $entity->last_online_at->format('H:i:s') }}
                    <br>
                    {{ $entity->last_online_at->format('Y.m.d') }}
                @endif
            </td>
            <td>
                {{ $entity->last_login_ip }}
            </td>
            <td class="controls">
                @include('AdminPanel::controls.edit')
                @include('AdminPanel::controls.destroy')
            </td>
        </tr>
    @endforeach
@endsection