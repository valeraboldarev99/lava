@if(count($items))
    <div>
        <h2>{{ $title }}</h2>
        <ul>
            @foreach($items as $item)
                <li>
                {{-- {{dd($item)}} --}}
                    <a href="{{ isset($item->route_name) ? route($item->route_name) : '#' }}">{{ $item->title }}</a>
                    @isset($item->preview)
                        <p>
                            {!! $item->preview !!}
                        </p>
                    @endisset
                </li>
            @endforeach
        </ul>
    </div>
@endif