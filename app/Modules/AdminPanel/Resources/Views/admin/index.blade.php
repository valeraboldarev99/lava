@extends('AdminPanel::layouts.app')

@section('title')
    <h2>title</h2>
@endsection

@section('topmenu')
    <div class="header-controls">
        @include('AdminPanel::controls.main_buttons')
    </div>
    @include('AdminPanel::common.localization')
@endsection

@section('content')
    @include('AdminPanel::common.errors')

    @if (count($entities) > 0)
        <table class="table entities__list">
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
        <p style="text-align: center;">{{__('AdminPanel::adminpanel.no_records')}}</p>
    @endif
@endsection