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
        return KiyohProduct::create($this);
    }

    public function getOrCreateKiyohProduct()
    {
        $product = $this->kiyohProduct->first();
        if ($product) {
            return $product;
        }

        if ($this->existsInKiyoh()) {
            $product_data = KiyohProduct::get($this);
            return ModelsKiyohProduct::create([
                'kiyoh_id' => $product_data['id'],
                'product_id' => $this->id,
                'cluster_id' => $product_data['cluster_id'],
                'product_code' => $product_data['product_code'],
                'cluster_code' => $product_data['cluster_code'] ?? null,
                'product_name' => $product_data['product_name'],
                'image_url' => $product_data['image_url'],
                'source_url' => $product_data['source_url'],
                'active' => $product_data['active'],
            ]);
        }

        if (config('app.env') == 'production') {
            return $this->addToKiyoh();
        }
    }

    public function kiyohProduct()
    {
        return $this->hasMany(ModelsKiyohProduct::class);
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
