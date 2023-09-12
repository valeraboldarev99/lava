<header>
    <div class="header__items">
		<div class="mobile-hamburger sidebar-open"><span></span></div>
        <div class="header__item">
            <div class="panel-name"><a href="{{ route(config('cms.admin_prefix') . 'admin_panel') }}">{{ config('cms.name') }}</a></div>
        </div>
        <div class="header__item header__item_menu">
            <div class="header__menu_item">
                <a href="{{ home() }}">
                    <i class="fa fa-home"></i>
                    <p class="header__menu_text">{{__('AdminPanel::adminpanel.goto_site')}}</p>
                </a>
            </div>
            <div class="header__menu_item header__menu_user">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <p class="header__menu_text">{{ Auth::user()->name }}</p>
                </a>
                <div class="user__drop">
                   <p>
                        <i class="fa fa-user"></i>
                        <a href="{{ route(config('cms.admin_prefix') . 'users.edit',  Auth::user()->id) }}">{{__('AdminPanel::auth.profile')}}</a>
                    </p>
                    <p>
                        <i class="fa fa-sign-out"></i>
                        <a href="{{ route('logout') }}">{{__('AdminPanel::auth.logout')}}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</header>