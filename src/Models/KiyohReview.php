<?php

namespace Marshmallow\Reviews\Kiyoh\Models;

use Illuminate\Database\Eloquent\Model;

class KiyohReview extends Model
{
    protected $guarded = [];

    protected $casts = [
        'dateSince' => 'datetime',
        'updatedSince' => 'datetime',
    ];
}
