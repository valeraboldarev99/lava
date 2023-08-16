@extends('AdminPanel::admin.index')

@section('title')
	<h2>Структура сайта</h2>
@endsection

@section('th')
    <th>@sortablelink('title', trans('AdminPanel::fields.name'))</th>
    <th>@sortablelink('slug', trans('AdminPanel::fields.slug'))</th>
    <th width="150">{{ __('Structure::adminpanel.module') }}</th>
    <th width="130">{{ __('AdminPanel::adminpanel.position') }}</th>
    <th>{{ __('AdminPanel::adminpanel.controls') }}</th>
@endsection

@section('td')
    @foreach ($entities as $entity)
        <tr {!! $entity->active == 1 ?: 'style="background:#f2dede;"' !!}>
            <td>
                {!! str_repeat('&nbsp', $entity->depth * 4) !!}
                {{ $entity->title }}
            </td>
            <td>
                {{ $entity->slug }}
            </td>
            <td>
                {{ $entity->module }}
            </td>
            <td>
                @if($entity->depth != 0)
                    @include('AdminPanel::controls.position', ['showPosition' => false])
                @endif
            </td>
            <td class="controls">
                @if($entity->depth != 0)
                    @include('AdminPanel::controls.publish')
                @endif
               @include('AdminPanel::controls.edit')
               @if($entity->depth != 0)
                    @include('AdminPanel::controls.destroy')
               @endif
            </td>
        </tr>
    @endforeach
@endsection