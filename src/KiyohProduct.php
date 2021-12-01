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

        dd($response->json());
    }

    public function create(Model $product)
    {
        $product_data = [
            'location_id' => config('kiyoh.location_id'),
            'product_code' => 'TEST_' . $product->getKiyohProductCode(),
            'product_name' => $product->getKiyohProductName(),
            'image_url' => $product->getKiyohProductImageUrl(),
            'source_url' => $product->getKiyohProductSourceUrl(),
            'active' => $product->getKiyohProductActive(),
            'cluster_id' => $product->getKiyohProductClusterId(),
            'cluster_code' => $product->getKiyohProductClusterCode(),
        ];

        $product_data = array_filter($product_data);

        // $response = Http::withHeaders([
        //     'X-Publication-Api-Token' => config('kiyoh.publication_api_token'),
        // ])->put(config('kiyoh.product_path'), $product_data);


        $response_data = [
            "id" => 19,
            "location_id" => "1018015",
            "product_code" => "0681495007813",
            "product_name" => "Kiyoh e-reader - Zwart",
            "image_url" => "https://www.voorbeeld.com/imgbase/imagebase3/thumb/FC/920000011751694
            7.jpg",
            "source_url" => "https://www.voorbeeld.com/nl/p/kiyoh-e-
            readerzwart/9200000117516947/",
            "active" => true,
            "cluster_id" => 1000007
        ];

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
