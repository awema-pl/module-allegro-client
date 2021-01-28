<?php

namespace AwemaPL\AllegroClient\Facades;

use AwemaPL\AllegroClient\Contracts\AllegroClient as AllegroClientContract;
use Illuminate\Support\Facades\Facade;

class AllegroClient extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return AllegroClientContract::class;
    }
}
