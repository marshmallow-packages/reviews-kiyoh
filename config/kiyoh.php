<?php

return [
    
    /**
     * Invites
     */
    'hash' => '',
    'location_id' => '',
    'language' => 'nl',
    'delay' => 3,
    'invite_path' => 'https://kiyoh.com/v1/invite/external',
    
    /**
     * XML feed
     */
    'feed_hash' => '',
    'cache_feed_in_seconds' => 3600, // Default is 1 hour
    'xml_path' => 'https://www.kiyoh.com/v1/review/feed.xml',
    'cache_name' => 'kiyoh_reviews_object',
    
];