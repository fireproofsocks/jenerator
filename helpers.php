<?php

if (!function_exists('getLocale'))
{
    /**
     * Gets a locale string to help make more meaningful fake data.
     *
     * @see http://php.net/manual/en/function.setlocale.php
     * @see https://www.shellhacks.com/linux-define-locale-language-settings/
     */
    function getLocale()
    {
        if (defined('JENERATOR_LOCALE')) {
            return JENERATOR_LOCALE;
        }

        // Use the system's LANG variable, which usually is something like en_US.UTF-8
        $lang = getenv('LANG');
        return substr($lang, 0, strpos($lang, '.'));
    }
}