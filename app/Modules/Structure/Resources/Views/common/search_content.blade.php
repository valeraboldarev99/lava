@if(count($items))
    <div>
        <h2>{{ $title }}</h2>
        <ul class="search__items">
            @foreach($items as $item)
                <li class="search__item">
                    <a href="{{ route($item->slug) }}">{{ $item->title }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endif