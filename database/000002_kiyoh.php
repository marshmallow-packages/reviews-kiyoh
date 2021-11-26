<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('kiyoh_reviews')) {
            Schema::create('kiyoh_reviews', function (Blueprint $table) {
                $table->bigIncrements('id');
                id
                dateSince
                updatedSince
                productCode
                productName
                image_url
                source_url
                active
                $table->timestamps();
            });
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kiyoh_products');
    }
};
