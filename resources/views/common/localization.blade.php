@foreach (config('localization.languages') as $locale)
    <a class="localization__link {{ getLang() == $locale['lang'] ? 'localization__link_act' : '' }}"
        href="/{{ $locale['lang'] }}"
    >{{$locale['lang']}}</a>
@endforeach