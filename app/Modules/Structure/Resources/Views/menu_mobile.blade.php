@if(isset($items))
    <div class="ms-menu">
        <ul class="ms-menu-items">
            @foreach ($items as $item)
                <li class="ms-menu_item">
                    <a href="{!! route($item->slug) !!}" class="ms-menu_link">{{ $item->title }}</a>
                    @if(count($item->children))
                        @include('Structure::main_mobile_children', ['childrens' => $item->children])
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif