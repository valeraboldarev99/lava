@extends('layouts.app')

@section('page_content')
    <div class="wrapper">
        <h2>{!! getPage()->title !!}</h2>
        {{-- {!! getSetting('about.lava') !!} --}}
        {{-- <br> --}}
        {!! getPage()->content !!}
    </div>
@endsection