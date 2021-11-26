<?php

namespace Marshmallow\Reviews\Kiyoh\Traits;

use Marshmallow\Reviews\Kiyoh\Facades\KiyohProduct;
use Marshmallow\Reviews\Kiyoh\Models\KiyohProduct as ModelsKiyohProduct;

trait KiyohProducts
{
    public function kiyoh()
    {
        return $this->hasOne(ModelsKiyohProduct::class);
    }

    public function addToKiyoh()
    {
        KiyohProduct::create($this);
    }

    public function existsInKiyoh()
    {
        $exists = KiyohProduct::get($this);
        return $exists !== null;
    }

    public function getKiyohProductActive(): bool
    {
        return true;
    }

    public function getKiyohProductClusterId(): ?int
    {
        return null;
    }

    public function getKiyohProductClusterCode(): ?string
    {
        return null;
    }

    abstract public function getKiyohProductCode(): string;
    abstract public function getKiyohProductName(): string;
    abstract public function getKiyohProductImageUrl(): string;
    abstract public function getKiyohProductSourceUrl(): string;
}
