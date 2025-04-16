<?php

if (! function_exists('getLocales')) {
    function getLocales(): array
    {
        return ['en', 'ar'];
    }
}

if (! function_exists('getDefaultLocale')) {
    function getDefaultLocale(): string
    {
        return config('app.default_locale', 'en');
    }
}

if(! function_exists('getImagesUrl')){
    function getImagesUrl(): string
    {
        return env("APP_URL", request()->root()) .'/public/images/';
    }
}
if(! function_exists('getAuthUserDomain')) {
    function getAuthUserDomain(): ?string
    {
        $email = auth()->user()->email ?? null;

        return $email ? substr(strrchr($email, "@"), 1) : null;
    }
}

