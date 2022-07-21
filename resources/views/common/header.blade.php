<header class="header">
    <div class="header__left">
        <div class="logo">
            <a href="{{ home() }}">
                <img src="/img/logo.png" alt="logo">
            </a>
        </div>
    </div>
    <div class="header__right">
        <div class="header__info">
            <div class="header__menu">
                @include('Users::main')
            </div>
        </div>
        @include('Structure::menu_main')
    </div>
</header>