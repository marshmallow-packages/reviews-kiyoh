<?php

namespace Marshmallow\Reviews\Kiyoh\Collections;

use Illuminate\Support\Collection;
use Marshmallow\Reviews\Kiyoh\Models\KiyohReview;

class ReviewCollection extends Collection
{
    protected $resource;
    protected $data;

    public function __construct($reponse_string)
    {
        $this->data = json_decode($reponse_string, true);
        if (array_key_exists('reviews', $this->data)) {
            foreach ($this->data['reviews'] as $review) {
                $this->items[] = new KiyohReview($review);
            }
        }
    }

    public function average($callback = NULL)
    {
        return floatval($this->getAttribute('averageRating'));
    }

    public function count()
    {
        return intval($this->getAttribute('numberReviews'));
    }

    public function average12months()
    {
        return floatval($this->getAttribute('last12MonthAverageRating'));
    }

    public function count12months()
    {
        return intval($this->getAttribute('last12MonthNumberReviews'));
    }

    public function recommendation()
    {
        return floatval($this->getAttribute('percentageRecommendation'));
    }

    public function getAttribute($attribute)
    {
        if (array_key_exists($attribute, $this->data)) {
            return $this->data[$attribute];
        }
        return null;
    }
}
