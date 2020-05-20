<?php

namespace Marshmallow\Reviews\Kiyoh;

use Exception;
use Illuminate\Support\Facades\Cache;
use Marshmallow\Reviews\Kiyoh\KiyohInvite;
use Marshmallow\Reviews\Kiyoh\Exceptions\KiyohException;

class Kiyoh
{
    protected $dont_fail = false;

    public function average ()
    {
        return floatval($this->getAttribute('averageRating'));
    }

    public function count ()
    {
        return intval($this->getAttribute('numberReviews'));
    }

    public function average12months ()
    {
        return floatval($this->getAttribute('last12MonthAverageRating'));
    }

    public function count12months ()
    {
        return intval($this->getAttribute('last12MonthNumberReviews'));
    }

    public function recommendation ()
    {
        return floatval($this->getAttribute('percentageRecommendation'));
    }

    public function dontFail ()
    {
        $this->dont_fail = true;
        return $this;
    }

    protected function getAttribute ($attribute)
    {
        $feed = $this->getFeed();
        if ($feed && $feed->{$attribute}) {
            return $feed->{$attribute};
        }
        return null;
    }

    protected function getFeed ()
    {
        if ($cached_version = Cache::get(config('kiyoh.cache_name'))) {
            return json_decode(
                $cached_version
            );
        }
        
        try {
            $xml = file_get_contents(
                $this->xmlFeedUrl()
            );
            $data = json_decode(json_encode((array) simplexml_load_string($xml)), true);
            $data['reviews'] = collect($data['reviews']);
            $data = (object) $data;
            $data = json_encode($data);

            $cache_in_seconds = env('KIYOH_CACHE_FEED_IN_SECONDS', config('kiyoh.cache_feed_in_seconds'));

            if ($cache_in_seconds) {
                Cache::store(env('CACHE_DRIVER'))
                        ->put(
                            config('kiyoh.cache_name'), 
                            $data, 
                            $cache_in_seconds
                        );
            }
            
            return json_decode($data);

        } catch (Exception $e) {
            if ($this->dont_fail === true) {
                return null;
            }
            throw new KiyohException("We could not get or parse the XML feed");
        }
    }

    protected function xmlFeedUrl ()
    {
        return config('kiyoh.xml_path') . '123?hash=' . env('KIYOH_FEED_HASH', config('kiyoh.feed_hash'));
    }
}
