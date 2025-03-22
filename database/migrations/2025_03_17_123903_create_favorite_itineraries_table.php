<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('favorite_itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ユーザーID
            $table->foreignId('itinerary_id')->constrained()->onDelete('cascade'); // 旅のしおりID
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorite_itineraries');
    }
};
