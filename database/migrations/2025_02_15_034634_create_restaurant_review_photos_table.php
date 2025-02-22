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
        Schema::create('restaurant_review_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_review_id'); // foreign key
            $table->string('photo', 255); // photo path or url
            $table->timestamps();

            $table->foreign('restaurant_review_id')
                ->references('id')
                ->on('restaurant_reviews')
                ->onDelete('cascade'); // 親レビューが削除されたら子写真も削除
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_review_photos');
    }
};
