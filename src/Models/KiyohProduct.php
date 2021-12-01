<?php

namespace Marshmallow\Reviews\Kiyoh\Models;

use Marshmallow\Reviews\Kiyoh\Kiyoh;
use Illuminate\Database\Eloquent\Model;

class KiyohProduct extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Kiyoh::$productModel);
    }
}
