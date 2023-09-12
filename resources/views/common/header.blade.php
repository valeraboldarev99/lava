<div class="page__header shade">
    <div class="wrapper">
        <header class="header">
            <div class="header__left">
                <div class="mobile-hamburger sidebar-open"><span></span></div>
                <div class="header__logo">
                    <a href="{{ home() }}">
                        <img src="/img/logo2.png" alt="logo">
                    </a>
                </div>
                <div class="mobile__icons">
                    @if(Auth::check())
                        <a href="{{ route('users.show', Auth::id()) }}" class="header__item_link header__user_link"></a>
                    @else
                        <a href="{{ route('login') }}" class="header__item_link header__user_link"></a>
                    @endif
                </div>
            </div>
            <div class="header__right">
                <div class="header__top">
                    @include('Search::user.search')
                    <div class="localization__block">
                        @include('common.localization')
                    </div>
                    <div class="header__social">
                        @include('common.social')
                    </div>
                    @if(getSetting('phone_number'))
                        <a href="tel:{!! preg_replace('/\D+/', '', getSetting('phone_number')) !!}" class="header__item_link header__phone_link"></a>
                    @endif
                    @if(Auth::check())
                        @if(Request::is('user_account'))
                            <a href="{{ route('users.edit', $entity->id) }}" 
								class="header__item_link header__user_link_edit"
								title="@lang('Users::index.edit')">
							</a>
							<a href="{{ route('logout') }}" 
								class="header__item_link header__user_link_logout"
								title="@lang('Users::index.logout')">
							</a>
						@else
							<a href="{{ route('users.userAccount') }}" class="header__item_link header__user_link"></a>
						@endif
                    @else
                        <a href="{{ route('login') }}" class="header__item_link header__user_link"></a>
                    @endif
                </div>
                <!-- end header top -->
                <div class="header__bottom">
                    @include('Structure::menu_main')
                </div>
                <!-- end header bottom -->
            </div>
            <!-- end header right -->
        </header>
    </div>
    <!-- end wrapper -->
</div>