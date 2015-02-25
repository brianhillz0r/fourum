<?php

if (! function_exists('gravatar'))  {
    /**
     * @param string $email
     * @param int $size
     * @return string
     */
    function gravatar($email, $size = 60) {
        $gravatar = new thomaswelton\GravatarLib\Gravatar();
        // example: setting default image and maximum size
        $gravatar->setDefaultImage('mm')
            ->setAvatarSize($size);
        // example: setting maximum allowed avatar rating
        $gravatar->setMaxRating('pg');
        return $gravatar->buildGravatarURL($email);
    }
}

if (! function_exists('theme')) {
    /**
     * @return Fourum\Theme\Theme
     */
    function theme() {
        return app('Fourum\Theme\Theme');
    }
}

if (! function_exists('user')) {
    /**
     * @return Fourum\User\UserInterface
     */
    function user() {
        return app('auth')->user();
    }
}

if (! function_exists('auth')) {
    /**
     * @return Illuminate\Contracts\Auth\Guard
     */
    function auth() {
        return app('auth');
    }
}

if (! function_exists('form')) {
    /**
     * @return Illuminate\Html\FormBuilder
     */
    function form() {
        return app('form');
    }
}

if (! function_exists('forum_name')) {
    /**
     * @return string
     */
    function forum_name() {
        return app('settings')->get('general.name');
    }
}

if (! function_exists('setting')) {
    /**
     * @param string $name
     * @return mixed
     */
    function setting($name) {
        return app('settings')->get($name);
    }
}

if (! function_exists('permissions')) {
    /**
     * @return Fourum\Permission\Checker\CheckerInterface
     */
    function permissions() {
        return app()->make('permissions', [app('auth')->user()]);
    }
}