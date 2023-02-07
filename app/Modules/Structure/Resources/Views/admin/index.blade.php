@extends('AdminPanel::admin.index')

@section('title')
	<h2>Структура сайта</h2>
@endsection

@section('th')
    <th>@sortablelink('title', trans('AdminPanel::fields.name'))</th>
    <th>@sortablelink('slug', trans('AdminPanel::fields.slug'))</th>
    <th width="150">Module</th>
    <th>{{ __('AdminPanel::adminpanel.controls') }}</th>
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
            <td>
                {{ $entity->module }}
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
        @foreach($entity->children as $child)
            <tr {!! $child->active == 1 ?: 'style="background:#f2dede;"' !!}>
                <td class="child_page">{{ $child->title }}</td>
                <td>{{ $child->slug }}</td>
                <td>
                    {{ $entity->module }}
                </td>
                <td class="controls">
                    @if($entity->depth != 0)
                        @include('AdminPanel::controls.publish', ['entity' => $child])
                    @endif
                    @include('AdminPanel::controls.edit', ['entity' => $child])
                    @if($entity->depth != 0)
                        @include('AdminPanel::controls.destroy', ['entity' => $child])
                    @endif
                </td>
            </tr>
        @endforeach
    @endforeach
@endsection