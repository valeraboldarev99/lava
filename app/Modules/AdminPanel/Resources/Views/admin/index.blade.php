@extends('AdminPanel::layouts.app')

@section('title')
    <h2>title</h2>
@endsection

@section('topmenu')
    @include('AdminPanel::controls.header_all')
@endsection

@section('content')
    @include('AdminPanel::common.errors')

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

        {{ $entities->links() }}

    @else
        <p>@lang('admin::admin.no_records')</p>
    @endif
@endsection