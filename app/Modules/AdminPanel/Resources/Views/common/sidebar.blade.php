<aside class="main-sidebar">
    <section class="sidebar__items">
        @foreach($menuItems as $menuItem)
            <div class="sidebar__item">
                <a href="{{ isset($menuItem['route']) ? route($menuItem['route']) : '#' }}">
                    <i class="{{ $menuItem['icon'] }}"></i>
                    <span>{{ $menuItem['title'] }}</span>
                </a>
            </div>
        @endforeach
    </section>
</aside>