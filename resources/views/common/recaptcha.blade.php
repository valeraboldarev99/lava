{{-- @include('common.recaptcha', [
    'theme' => 'light', //'light', 'dark'
    'size' => 'normal', //'normal', 'compact'
    'other' => 'id="custom_id" data-id="custom_data-id"',
]) --}}

<script src="https://www.google.com/recaptcha/api.js" async="" defer=""></script>

<div 
    class="g-recaptcha"
    data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"
    data-theme="{{ isset($theme) ? $theme : config('recaptcha.theme') }}"
    data-size="{{ isset($size) ? $size : config('recaptcha.size') }}"
    {{ isset($other) ? $other : '' }}
    >
</div>
