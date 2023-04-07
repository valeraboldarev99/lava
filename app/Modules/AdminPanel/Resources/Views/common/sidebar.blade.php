<section class="sidebar__items">
    @if(isset($items))
        @foreach($items as $group)
            <div class="group">
                <div class="group__header">
                    <div class="group__btn">
                        <i class="{{ $group['icon'] }}"></i>
                        <span>{{ $group['title'] }}</span>
                    </div>
                </div>
                <div class="group__content">
                    @foreach($group['items'] as $item)
                        <div class="sidebar__item">
                            <a href="{{ isset($item['route']) ? route($item['route']) : '#' }}">
                                <i class="{{ $item['icon'] }}"></i>
                                <span>{{ $item['title'] }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</section>