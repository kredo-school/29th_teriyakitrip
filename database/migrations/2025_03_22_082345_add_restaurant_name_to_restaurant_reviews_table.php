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
        Schema::table('restaurant_reviews', function (Blueprint $table) {
            $table->string('restaurant_name')->nullable()->after('place_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurant_reviews', function (Blueprint $table) {
            $table->dropColumn('restaurant_name');
        });
    }
};
