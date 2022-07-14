<header>
    <div class="header__items">
        <div class="header__item">
            <div class="panel-name"><a href="{{ route('admin_panel') }}">{{ config('cms.name') }}</a></div>
        </div>
        <div class="header__item header__item_menu">
            <div class="header__menu_item">
                <i class="fa fa-home"></i>
                <a href="{{ home() }}">@lang('AdminPanel::adminpanel.goto_site')</a>
            </div>
            <div class="header__menu_item header__menu_user">
                <i class="fa fa-user"></i>
                <a href="#">
                    {{ Auth::user()->name }}
                </a>
                <div class="user__drop">
                   <p>
                        <i class="fa fa-user"></i>
                        <a href="{{ route('admin.users.edit',  Auth::user()->id) }}">@lang('AdminPanel::auth.profile')</a>
                    </p>
                    <p>
                        <i class="fa fa-sign-out"></i>
                        <a href="{{ route('logout') }}">@lang('AdminPanel::auth.logout')</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</header>