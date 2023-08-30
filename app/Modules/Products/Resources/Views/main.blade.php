@if(isset($items) && count($items))
    <div class="block__block">
        <h2 class="block__block_header">
            {{ __('Products::index.title') }}
        </h2>
        <div class="block__items">
            @foreach($items as $item)
                <div class="block__item">
                    <div class="block__pic">
                        <img src="{{ $item->getImageWebpPath('image', 'big', 'Products') }}" alt="{{ $item->title }}">
                    </div>
                    <div class="block__info">
                        <h4 class="block__info_title">{{ $item->title }}</h4>
                    </div>
                    <a href="{{ route('products.show', ['id' => $item->id]) }}" class="mask"></a>
                </div>
            @endforeach
        </div>
    </div>
@endif