@extends('AdminPanel::layouts.app')

@section('title')
    <h2>{{ __('Search::adminpanel.title') }}</h2>
@endsection

@section('topmenu')
    @include('AdminPanel::common.localization')

    <div class="header__search">
        @include('Search::admin.search')

        @if(isset($results))
            <p>{{ __('Search::adminpanel.total_results', ['query' => $query, 'total_result' => $total_result]) }}</p>
        @endif
    </div>
@endsection

@section('content')
    @include('AdminPanel::common.errors')

    @if(isset($results) && $total_result)
        @foreach($results as $result)
            {!! $result !!}
        @endforeach
    @else
        <p>
            @lang('Search::adminpanel.nothing_found')
        </p>
    @endif
@endsection