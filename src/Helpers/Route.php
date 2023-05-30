<?php

namespace NadzorServera\Skijasi\Module\Content\Helpers;

class Route
{
    public static function getController($key)
    {
        // get config 'controllers' from config/skijasi-content.php
        $controllers = config('skijasi-content.controllers');

        // if the key is not found, return $key
        if (! isset($controllers[$key])) {
            return 'NadzorServera\\Skijasi\\Module\\Content\\Controllers\\'.$key;
        }

        // return the value of the key
        return $controllers[$key];
    }
}
