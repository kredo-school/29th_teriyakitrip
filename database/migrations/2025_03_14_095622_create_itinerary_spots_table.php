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
        Schema::create('itinerary_spots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('itinerary_id');
            $table->string('place_id'); // Google Places APIのID           
            $table->integer('spot_order')->default(1); // 並び順
            $table->time('visit_time')->default('00:00:00')->nullable(); // 時間
            $table->integer('visit_day')->default(1); // いつ（○日目）
            $table->timestamps();
            ;

            // 🔹 外部キー制約
            $table->foreign('itinerary_id')->references('id')->on('itineraries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary_spots');
    }
};
