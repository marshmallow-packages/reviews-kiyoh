<?php

namespace App\Jobs\Kiyoh;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Marshmallow\Reviews\Kiyoh\Models\KiyohProduct;

class UpdateProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product;

    private $hash;

    private $location_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->hash = config('kiyoh.hash');
        $this->location_id = config('kiyoh.location_id');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cluster_code = $this->product->cluster_code;
        $product_code = $this->product->kiyoh_code;

        $put_data = $this->createPutData($product_code, $cluster_code);
        $response = $this->updateKiyoh($put_data);
        $this->addToDatabase($response, $put_data);
    }

    public function changeUrl($url)
    {
        $current_domain = config('app.url');
        $new_domain = $this->product->domains->first();
        $path = Str::of($url)->after($current_domain)->after('/')->toString();
        $domain_url = $new_domain->domain ?? $current_domain;
        if ($path && !Str::startsWith($path, '/')) {
            $path = '/' . $path;
        }

        return "https://{$domain_url}{$path}";
    }

    public function createPutData($product_code, $cluster_code)
    {
        $org_image_url = $this->product->main_image;
        $org_source_url = $this->product->route();

        $image_url = $this->changeUrl($org_image_url);
        $source_url = $this->changeUrl($org_source_url);

        $active = $this->product->active ? true : false;

        if ($this->product->trashed()) {
            $active = false;
        }

        $put_data = [
            'product_code' => $product_code,
            'product_name' => $this->product->name,
            'image_url' => $image_url,
            'source_url' => $source_url,
            'active' => $active,
            'cluster_code' => $cluster_code,
        ];

        return $put_data;
    }

    public function updateKiyoh($put_data)
    {
        $update_url = 'https://klantenvertellen.nl/v1/location/product/external';

        $put_data['location_id'] = $this->location_id;

        $response = Http::withHeaders([
            'X-Publication-Api-Token' => $this->hash,
        ])->put($update_url, $put_data);

        if ($response->failed()) {
            $response->throw();
        }

        return $response->json();
    }

    public function addToDatabase($kiyoh_data, $put_data)
    {
        $put_data['kiyoh_id'] = $kiyoh_data['id'];
        $put_data['cluster_id'] = $kiyoh_data['cluster_id'];
        $put_data['product_id'] = $this->product->id;

        KiyohProduct::updateOrCreate([
            'kiyoh_id' => $kiyoh_data['id'],
            'product_id' => $this->product->id,
        ], $put_data);
    }
}
