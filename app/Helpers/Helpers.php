<?php

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;


if (!function_exists('secure_image_url')) {
    function secure_image_url(string $PathUrl, array $params = [], int $validForMinutes = 10): string
    {
        $allParams = array_merge(['path' => $PathUrl], $params);
        return URL::signedRoute('image.serve', $allParams, now()->addMinutes($validForMinutes));
    }
}


function currencySymbol() {
    $symbol = DB::table('settings')->where('key_name', 'currency_symbol')->value('value');
    return $symbol ?? '$'; // default fallback
}
