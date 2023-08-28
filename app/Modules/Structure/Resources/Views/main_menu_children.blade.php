<ul class="drop__menu_items">
    @foreach($childrens as $child)
        <li class="drop__menu_item">
            <a href="{{ route($child->slug) }}" class="drop__menu_link">
                {!! str_repeat('&nbsp', ($child->depth - 2) * 2) !!} 
                {{ $child->title }}
            </a>

            @if(count($child->children))
                @include('Structure::main_menu_children', ['childrens' => $child->children])
            @endif
        </li>
    @endforeach
</ul>