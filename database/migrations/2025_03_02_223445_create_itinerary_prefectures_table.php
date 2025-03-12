<?php  //created by Sunao

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
            $table->foreignId('itinerary_id')->constrained('itineraries')->onDelete('cascade');
            $table->foreignId('prefecture_id')->constrained('prefectures')->onDelete('cascade');

            // Prevention of duplicate registration
            $table->primary(['itinerary_id', 'prefecture_id']);
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
