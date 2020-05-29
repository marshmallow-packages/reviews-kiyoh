<?php

return [

    /**
     * Invites
     */
    'hash' => '',
    'location_id' => '',
    'language' => 'nl',
    'delay' => 3,
    'invite_path' => 'https://www.klantenvertellen.nl/v1/invite/external',

    /**
     * XML feed
     */
    'feed_hash' => '',
    'cache_feed_in_seconds' => 3600, // Default is 1 hour
    'review_path' => 'https://www.klantenvertellen.nl/v1/publication/review/external',
    'cache_name' => 'kiyoh_reviews_object',

];
