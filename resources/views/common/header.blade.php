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
        <nav class="header__menu">
            <ul>
                <li><a href="/users">Users</a></li>
                <li><a href="/settings">Settings</a></li>
            </ul>
        </nav>
    </div>
</header>