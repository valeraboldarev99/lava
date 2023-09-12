@extends('layouts.wide')

@section('content')
	<div class="wrapper">
        <h1>{{ __('Search::index.title') }}</h1>
        <div class="header__search">
            @include('Search::user.search')

            @if(isset($results))
                <p>{{ __('Search::index.total_results', ['query' => $query, 'total_result' => $total_result]) }}</p>
            @endif
        </div>
        @include('AdminPanel::common.errors')

        @if(isset($results) && $total_result)
            @foreach($results as $result)
                {!! $result !!}
            @endforeach
        @else
            <p>
                @lang('Search::index.nothing_found')
            </p>
        @endif
    </div>
@endsection
