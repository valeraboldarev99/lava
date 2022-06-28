@extends('AdminPanel::layouts.app')

@section('title')
    <h2>title</h2>
@endsection

@section('topmenu')
    @include('AdminPanel::controls.all')
@endsection

@section('content')
    {{-- @include('admin::common.errors') --}}

    @if (count($entities) > 0)
        <table class="entities__list">
            <thead>
                <tr>
                    @yield('th')
                </tr>
            </thead>
            <tbody>
                @yield('td')
            </tbody>
        </table>

        {{-- {!! $entities->appends(\Request::except('page'))->render() !!} --}}
    @else
        <p>@lang('admin::admin.no_records')</p>
    @endif
@endsection