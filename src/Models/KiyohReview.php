<?php

namespace Marshmallow\Reviews\Kiyoh\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class KiyohReview extends Model
{
    protected $guarded = [];

    protected $casts = [
        'dateSince' => 'datetime',
        'updatedSince' => 'datetime',
    ];

    public static function createFromProductFeed($review, $product_id = null)
    {
        if (!$product_id) {
            $kiyohProduct = KiyohProduct::where('product_code', $review->productCode)->first();
            $product_id = $kiyohProduct->product_id;
        }

        if ($review->referenceCode) {
            // SendThankYouDiscountCode::dispatch($review->referenceCode, new DiscountForReview);
        }

        $kiyoh_review = self::where('kiyoh_review_id', $review->reviewId)->first();

        if ($kiyoh_review) {
            $update_array = Arr::whereNotNull([
                'product_id' => $product_id,
                'kiyoh_product_review_id' => $review->productReviewId,
                'rating' => $review->rating,
                'title' => $review->oneliner ?? null,
                'content' => $review->description ?? null,
            ]);

            return $kiyoh_review->update(
                $update_array
            );
        }

        $kiyoh_product_review = self::where('kiyoh_product_review_id', $review->productReviewId)->first();
        if ($kiyoh_product_review) {
            return $kiyoh_product_review;
        }

        return self::create([
            'product_id' => $product_id,
            'kiyoh_review_id' => $review->reviewId ?? $review->productReviewId,
            'kiyoh_product_review_id' => $review->productReviewId,
            'author' => $review->reviewAuthor,
            'city' => $review->city,
            'rating' => $review->rating,
            'title' => $review->oneliner,
            'content' => $review->description,
            'recommend' => null,
        ]);
    }

    public static function createFromFeed($review): self
    {
        $exists = self::where('kiyoh_review_id', $review->reviewId)->first();

        if ($review->referenceCode) {
            // SendThankYouDiscountCode::dispatch($review->referenceCode, new DiscountForReview);
        }

        if ($exists) {
            return $exists;
        }

        $reviewContent = $review->reviewContent;

        $reviewContent = collect($reviewContent);

        $review->recommend = null;
        $review->title = null;
        $review->content = null;

        $reviewContent->each(function ($content, $key) use ($review) {
            match ($content['questionGroup']) {
                'DEFAULT_RECOMMEND' => ($review->recommend = Arr::get($content, 'rating', null)),
                'DEFAULT_OPINION' => ($review->content = Arr::get($content, 'rating', null)),
                'DEFAULT_ONELINER' => ($review->title = Arr::get($content, 'rating', null)),
                default => null,
            };
        });

        return self::create([
            'kiyoh_review_id' => $review->reviewId,
            'author' => $review->reviewAuthor,
            'city' => $review->city,
            'rating' => $review->rating,
            'title' => $review->title,
            'content' => $review->content,
            'recommend' => $review->recommend === 'true',
            'data' => $review,
        ]);
    }
}
