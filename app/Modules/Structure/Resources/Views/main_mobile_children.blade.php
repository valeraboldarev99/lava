<ul class="ms-menu-items">
    @foreach($childrens as $child)
        <li class="ms-menu_item">
            <a href="{{ route($child->slug) }}" class="ms-menu_link">
                {!! str_repeat('-', $child->depth) !!} 
                {{ $child->title }}
            </a>

            @if(count($child->children))
                @include('Structure::main_mobile_children', ['childrens' => $child->children])
            @endif
        </li>
    @endforeach
</ul>