<?php

namespace Marshmallow\Reviews\Kiyoh\Console\Commands;

use Illuminate\Console\Command;
use Marshmallow\Reviews\Kiyoh\Facades\Kiyoh;

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
        $reviews = Kiyoh::withoutCache()->feed();
        foreach ($reviews as $review) {
            // Do your own magic here
        }
    }
}
