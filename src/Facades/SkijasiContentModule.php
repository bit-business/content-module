<?php

namespace NadzorServera\Skijasi\Module\Content\Facades;

use Illuminate\Support\Facades\Facade;

class SkijasiContentModule extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'skijasi-content-module';
    }
}
