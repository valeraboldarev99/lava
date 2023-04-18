@extends('layouts.app')

@section('page_content')
    <h2>{!! getPage()->title !!}</h2>
    {{-- {!! getSetting('about.lava') !!} --}}
    {{-- <br> --}}
    {!! getPage()->content !!}
@endsection