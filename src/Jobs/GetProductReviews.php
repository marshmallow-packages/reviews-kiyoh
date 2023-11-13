<?php

namespace App\Jobs\Kiyoh;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Marshmallow\Reviews\Kiyoh\Facades\Kiyoh;
use Marshmallow\Reviews\Kiyoh\Models\KiyohReview;

class GetProductReviews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reviews = Kiyoh::withoutCache()->product($this->product->kiyoh_code);
        $reviews->each(function ($review) {
            KiyohReview::createFromProductFeed($review);
        });
    }
}
