<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('itinerary_prefectures', function (Blueprint $table) {
            $table->unsignedBigInteger('itinerary_id');
            $table->string('prefecture_id');

            $table->foreign('itinerary_id')->references('id')->on('itineraries');
            $table->foreign('prefecture_id')->references('name')->on('prefectures');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary_prefectures');
    }
};
