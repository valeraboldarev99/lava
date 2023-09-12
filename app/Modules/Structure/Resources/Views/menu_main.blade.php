@if(isset($items))
	<nav class="header__menu">
	    <ul class="header__menu_items">
	    	@foreach($items as $item)
	        	<li class="header__menu_item">
                    <a href="{{ route($item->slug) }}"
                         {!! (Request::is($item->slug) ? 
                            'class="header__menu_link act"' : 
                            'class="header__menu_link"') 
                         !!}>
                        {{ $item->title }}
                    </a>
                    @if(count($item->children))
                        <div class="header__drop_menu">
                            @include('Structure::main_menu_children', ['childrens' => $item->children])
                        </div>
                    @endif
                </li>
	    	@endforeach
	    </ul>
	</nav>
@endif