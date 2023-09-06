<div class="sidebar-overlay"></div>
<div class="sidebar">
    <div class="sidebar-block">
        <div class="sidebar-block__top">
            <div class="user-sidebar__logo">
                <a href="{{ home() }}">
                    <img src="/img/logo2.png" class="sidebar__logo" alt="logo">
                </a>
            </div>
            <div class="sidebar-block__close sidebar-close">&nbsp;</div>
        </div>
        <div class="sidebar-block__content">
            <div class="sidebar-block__menu">
                @include('Structure::menu_mobile')
            </div>
            <div class="sidebar__contacts">
                @include('Search::user.search')
                <div class="header__phone">
                    @if(getSetting('phone_number'))
                        <a href="tel:{!! preg_replace('/\D+/', '', getSetting('phone_number')) !!}" class="header__phone_number" target="_blank">
                            {{ getSetting('phone_number') }}
                        </a>
                    @endif
                </div>
                <div class="localization__block">
                    @include('common.localization')
                </div>
                <div class="header__social">
                    @include('common.social')
                </div>
            </div>
        </div>
    </div>
</div>
