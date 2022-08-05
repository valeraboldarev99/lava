<?php

namespace App\Helpers;

class Localization
{
    public function locale() {
        $locale = request()->segment(1, '');
        if($locale && in_array($locale, config("localization.locales"))) {
            return $locale;
        }

        return '';
    }
}