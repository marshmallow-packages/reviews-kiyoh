<?php

namespace Marshmallow\Reviews\Kiyoh\Console\Commands;

use Illuminate\Console\Command;
use Marshmallow\Reviews\Kiyoh\Facades\Kiyoh;
use Marshmallow\Reviews\Kiyoh\Models\KiyohReview;

class StoreReviewsInDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kiyoh:store-reviews-in-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all the reviews from Kiyoh and store them in the database.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Kiyoh::withoutCache()->feed()->each(function ($review) {
            KiyohReview::createFromFeed($review);
        });
    }
}
