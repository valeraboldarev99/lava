@if(checkModelLocalization($model_name))
    <div class="localization__block">
        @foreach (config('localization.languages') as $locale)
            <li class="localization__item">
                <a href="{{ adminLocale($locale['lang']) }}"
                    class="localization__link {{ getLang() == $locale['lang'] ? 'localization__link_act' : '' }}">
                    {{ $locale['name'] }}
                </a>
            </li>
        @endforeach
    </div>
@endif