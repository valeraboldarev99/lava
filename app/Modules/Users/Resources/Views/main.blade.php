<div class="user__btns">
    @if(Auth::user())
        <a class="btn btn-primary" href="{{ route('admin_panel') }}">В админ панель</a>
        <a class="btn btn-default" href="{{ route('logout') }}">Выйти</a>
    @else
        <a class="btn btn-primary" href="{{ route('adminpanel') }}">Войти как админ</a>
        <a class="btn btn-success" href="{{ route('login') }}">Войти как пользователь</a>
    @endif
</div>