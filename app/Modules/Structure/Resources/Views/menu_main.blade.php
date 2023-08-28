@if(isset($items))
	<nav class="header__menu">
	    <ul class="header__menu_items">
	    	@foreach($items as $item)
	        	<li class="header__menu_item">
                    <a href="{{ route($item->slug) }}"
                         {!! (Request::is($item->slug) ? 'class="act"' : '') !!}
                    >
                        {{ $item->title }}
                    </a>
                    @if(count($item->children))
                        <div class="header__drop_menu">
                            <ul class="drop__menu_items">
                                @foreach($item->children as $child)
                                    <li class="drop__menu_item">
                                        <a href="{{ route($child->slug) }}" class="drop__menu_link">
                                            {{ $child->title }}
                                        </a>

                                        @if(count($child->children))
                                            <ul>
                                                @foreach($child->children as $child)
                                                    <li>
                                                        <a href="{{ route($child->slug) }}">---{{ $child->title }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
	    	@endforeach
	    </ul>
	</nav>
@endif