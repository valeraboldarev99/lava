@extends('layouts.wide')

@section('content')
    <div class="wrapper">
        <div class="contacts__info">
            {!! $page->content !!}
        </div>
        <div class="block__block">
            @if(isset($items) && count($items))
                <div class="block__block">
                    @if(count($categories))
                        <div class="product__categogies_items">
                            @foreach($categories as $category)
                                @if(count($products->where('category_id',$category->id)))
                                    <a href="{{ route('products.categories', [
                                                        'parent_slug' => $parent_category->id,
                                                        'slug' => $category->id]) }}"
                                            {!! $checked_category->id == $category->id ?  'class="product__categogies_item product__categogies_item-act"' : 'class="product__categogies_item"' !!} >
                                        {{$category->title}}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <div class="block__items">
                        @foreach($items as $item)
                            <div class="block__item">
                                <div class="block__pic">
                                    <img src="{{ $item->getImageWebpPath('image', 'big', 'Products') }}" alt="{{ $item->title }}">
                                </div>
                                <div class="block__info">
                                    <h4 class="block__info_title">{{ $item->title }}</h4>
                                </div>
                                <a href="{!! route('products.show', ['id' => $item->id]) !!}" class="mask"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- {{dd($items)}} --}}
            	{!! $items->appends(request()->query())->links('common.paginate') !!}
            @else	
                @lang('AdminPanel::index.no_records')
            @endif
        </div>
    </div>
@endsection