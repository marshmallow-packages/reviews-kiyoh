<?php

namespace Marshmallow\Reviews\Kiyoh\Facades;

use Illuminate\Support\Facades\Facade;

class KiyohProduct extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Marshmallow\Reviews\Kiyoh\KiyohProduct::class;
    }
}
