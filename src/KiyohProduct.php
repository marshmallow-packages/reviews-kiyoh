<?php

namespace Marshmallow\Reviews\Kiyoh;

use Illuminate\Support\Facades\Http;
use Marshmallow\Reviews\Kiyoh\Kiyoh;
use Illuminate\Database\Eloquent\Model;

class KiyohProduct
{
    public function get(Model $product)
    {
        $response = Http::withHeaders([
            'X-Publication-Api-Token' => config('kiyoh.publication_api_token'),
        ])->get(config('kiyoh.product_path') . '?locationId=' . config('kiyoh.location_id'));

        $data = $response->json();
        foreach ($data as $kiyoh_product) {
            if ($product->gtin == $kiyoh_product['product_code']) {
                return $kiyoh_product;
            }
        }

        return null;
    }

    public function create(Model $product)
    {
        $product_data = [
            'location_id' => config('kiyoh.location_id'),
            'product_code' => $product->getKiyohProductCode(),
            'product_name' => $product->getKiyohProductName(),
            'image_url' => $product->getKiyohProductImageUrl(),
            'source_url' => $product->getKiyohProductSourceUrl(),
            'active' => $product->getKiyohProductActive(),
            'cluster_id' => $product->getKiyohProductClusterId(),
            'cluster_code' => $product->getKiyohProductClusterCode(),
        ];

        $product_data = array_filter($product_data);

        $response = Http::withHeaders([
            'X-Publication-Api-Token' => config('kiyoh.publication_api_token'),
        ])->put(config('kiyoh.product_path'), $product_data);

        $response_data = $response->json();

        Kiyoh::$kiyohProductModel::updateOrCreate([
            'product_id' => $product->id,
        ], [
            'kiyoh_id' => $response_data['id'],
            'cluster_id' => $response_data['cluster_id'],
            'product_code' => $product->getKiyohProductCode(),
            'cluster_code' => $product->getKiyohProductClusterCode(),
            'product_name' => $product->getKiyohProductName(),
            'image_url' => $product->getKiyohProductImageUrl(),
            'source_url' => $product->getKiyohProductSourceUrl(),
            'active' => $product->getKiyohProductActive(),
        ]);
    }
}
