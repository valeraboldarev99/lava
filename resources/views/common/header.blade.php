<header class="header">
    <div class="header__left">
        <div class="logo">
            <a href="{{ home() }}">
                <img src="/img/logo2.png" alt="logo">
            </a>
        </div>
    </div>
    <div class="header__right">
        <div class="header__info">
            <div class="localization__block">
                @foreach (config('localization.locales') as $locale)
                    <li class="localization__item">
                        <a class="localization__link {{ getLang() == $locale ? 'localization__link_act' : '' }}"
                            href="/{{ $locale }}">
                            {{ $locale }}
                        </a>
                    </li>
                @endforeach
            </div>
            <div class="header__menu">
                @include('Users::main')
            </div>
        </div>
        @include('Structure::menu_main')
    </div>
</header>