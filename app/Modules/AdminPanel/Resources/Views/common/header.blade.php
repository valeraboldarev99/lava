<header>
    <div class="header__items">
        <div class="header__item">
            <div class="panel-name">{{ config('cms.name') }}</div>
        </div>
        <div class="header__item header__item_menu">
            <div class="header__menu_item">
                <i class="fa fa-home"></i>
                <a href="{{ home() }}">@lang('AdminPanel::adminpanel.goto_site')</a>
            </div>
            <div class="header__menu_item">
                <i class="fa fa-user"></i>
                <a href="#">
                    {{ Auth::user()->name }}
                </a>
            </div>
            <div class="header__menu_item">
                <i class="fa fa-sign-out"></i>
                <a href="{{ route('logout') }}">@lang('AdminPanel::auth.logout')</a>
            </div>
        </div>
    </div>
</header>