<?php

namespace Marshmallow\Reviews\Kiyoh;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Marshmallow\Reviews\Kiyoh\KiyohInvite;
use Marshmallow\Reviews\Kiyoh\Exceptions\KiyohException;
use Marshmallow\Reviews\Kiyoh\Collections\ReviewCollection;
use Marshmallow\Reviews\Kiyoh\Exceptions\KiyohInviteException;
use Marshmallow\Reviews\Kiyoh\Http\Resources\KiyohFeedResource;

class Kiyoh
{
    protected $use_cache = true;
    protected $dont_fail = false;

    public function dontFail()
    {
        $this->dont_fail = true;
        return $this;
    }

    public function withoutCache($without_cache = true)
    {
        $this->use_cache = (!$without_cache);
        return $this;
    }

    public function feed(): ?ReviewCollection
    {
        if ($this->use_cache === true && $cached_version = Cache::get(config('kiyoh.cache_name'))) {
            return new ReviewCollection(
                $cached_version,
                true
            );
        }

        try {
            $response = Http::withHeaders(
                [
                    'X-Publication-Api-Token' => env('KIYOH_HASH', config('kiyoh.hash')),
                ]
            )->get($this->reviewApiEndpoint());

            if (!$response->successful()) {
                throw new KiyohInviteException($response->json());
            }

            $cache_in_seconds = env('KIYOH_CACHE_FEED_IN_SECONDS', config('kiyoh.cache_feed_in_seconds'));
            if ($this->use_cache === true && $cache_in_seconds) {
                Cache::store(env('CACHE_DRIVER'))
                        ->put(
                            config('kiyoh.cache_name'),
                            $response->body(),
                            $cache_in_seconds
                        );
            }

            return new ReviewCollection(
                $response->body()
            );
        } catch (Exception $e) {
            if ($this->dont_fail === true) {
                return null;
            }
            throw new KiyohException($e->getMessage());
        }
    }

    protected function reviewApiEndpoint()
    {
        return config('kiyoh.review_path') . '?locationId=' . env('KIYOH_LOCATION_ID', config('kiyoh.location_id'));
    }
}
