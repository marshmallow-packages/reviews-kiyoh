<?php

return [

    /**
     * Invites
     */
    'hash' => env('KIYOH_INVITE_HASH', null),
    'location_id' => env('KIYOH_LOCATION_ID', null),
    'language' => env('KIYOH_LANGUAGE', 'nl'),
    'delay' => env('KIYOH_INVITE_DELAY_IN_DAYS', 3),
    'invite_path' => 'https://www.klantenvertellen.nl/v1/invite/external',

    /**
     * XML feed
     */
    'feed_hash' => env('KIYOH_FEED_HASH', null),
    'cache_feed_in_seconds' => env('KIYOH_FEED_CACHE_TTL', 3600),
    'review_path' => 'https://www.klantenvertellen.nl/v1/publication/review/external',
    'cache_name' => env('KIYOH_FEED_CACHE_NAME', 'kiyoh_reviews_object'),

    /**
     * Products
     */
    'product_path' => 'https://www.kiyoh.com/v1/location/product/external',
    'publication_api_token' => env('KIYOH_PUBLICATION_API_TOKEN', null),

    /**
     * Models
     */
    'models' => [
        'product' => \Marshmallow\Reviews\Kiyoh\Models\KiyohProduct::class,
    ],

];
