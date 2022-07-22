@if(isset($items))
	<nav class="header__menu">
	    <ul>
	    	@foreach($items as $item)
	        	<li><a href="{{ route($item->slug) }}">{{ $item->title }}</a></li>
	    	@endforeach
	    </ul>
	</nav>
@endif