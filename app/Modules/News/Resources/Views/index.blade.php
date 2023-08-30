@extends('layouts.wide')

@section('content')
	<div class="wrapper">
        <div class="contacts__info">
            {{-- {!! $page->content !!} --}}
        </div>
        <div class="block__block">
            <h2 class="block__block_header">
                {{ __('News::index.title') }}
            </h2>
            <div class="block__items">
                @foreach($items as $item)
                    <div class="block__item">
                        <div class="block__pic">
                            <img src="{{ $item->getImageWebpPath('image', 'big', 'News') }}" alt="{{ $item->title }}">
                        </div>
                        <div class="block__info">
                            <h4 class="block__info_title">{{ $item->title }}</h4>
                            <p class="block__info_text">{{ $item->preview }}</p>
                        </div>
                        <a href="{{ route('news.show', ['id' => $item->id]) }}" class="mask"></a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection