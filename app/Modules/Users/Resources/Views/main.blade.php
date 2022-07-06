<div class="user__btns">
    @if(Auth::user())
    	<span>{{ Auth::user()->name }}</span>
    	@if(Auth::user()->isAdmin())
        	<a class="btn btn-primary" href="{{ route('admin_panel') }}">В админ панель</a>
    	@elseif(Auth::user()->isUser())
        	<a class="btn btn-primary" href="#">В кабинет</a>
    	@elseif(Auth::user()->isDisabled())
        	<p class="text-danger">Вы заблокированы</p>
    	@endif
        <a class="btn btn-default" href="{{ route('logout') }}">Выйти</a>
    @else
        <a class="btn btn-primary" href="{{ route('adminpanel') }}">Войти как админ</a>
        <a class="btn btn-success" href="{{ route('login') }}">Войти как пользователь</a>
    @endif
</div>