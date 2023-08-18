<div class="user__btns">
    @if(Auth::user())
    	<span>{{ Auth::user()->name }}</span>
    	@if(Auth::user()->isAdmin())
        	<a class="btn btn-primary" href="{{ route('admin.admin_panel') }}">{{ __('Users::index.in_adminpanel') }}</a>
    	@elseif(Auth::user()->isUser())
        	<a class="btn btn-primary" href="{{ route('users.show', Auth::id()) }}">{{ __('Users::index.in_useraccount') }}</a>
    	@elseif(Auth::user()->isDisabled())
        	<span class="text-danger">{{ __('Users::index.disabled') }}</span>
    	@endif
        <a class="btn btn-default" href="{{ route('logout') }}">{{ __('Users::index.logout') }}</a>
    @else
        <a class="btn btn-primary" href="{{ route('adminpanel') }}">{{ __('Users::index.login_as_admin') }}</a>
        <a class="btn btn-success" href="{{ route('login') }}">{{ __('Users::index.login_as_user') }}</a>
    @endif
</div>