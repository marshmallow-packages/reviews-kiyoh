<?php

namespace Marshmallow\Reviews\Kiyoh\Facades;

use Illuminate\Support\Facades\Facade;

class KiyohInvite extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Marshmallow\Reviews\Kiyoh\KiyohInvite::class;
    }
}
