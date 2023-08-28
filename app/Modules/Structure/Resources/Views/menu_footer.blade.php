@if(isset($items))
    <h4 class="footer__item_header">@lang('index.menu_header')</h4>
    <ul class="footer__menu_items">
        @foreach ($items as $item)
            <li class="footer__menu_item">
                <a href="{!! route($item->slug) !!}" class="footer__menu_link">{{ $item->title }}</a>
            </li>
        @endforeach
    </ul>
@endif