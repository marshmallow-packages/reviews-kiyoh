<?php 

namespace Marshmallow\Reviews\Kiyoh\Facades;

use Illuminate\Support\Facades\Facade;

class Kiyoh extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Marshmallow\Reviews\Kiyoh\Kiyoh::class;
    }
}