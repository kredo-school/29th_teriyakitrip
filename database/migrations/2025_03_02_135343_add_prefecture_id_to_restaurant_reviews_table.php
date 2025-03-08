<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('restaurant_reviews', function (Blueprint $table) {
            $table->foreignId('prefecture_id')->nullable()->constrained('prefectures');
            // 🔥 `prefectures.id` を参照する外部キーを追加
        });
    }

    public function down(): void
    {
        Schema::table('restaurant_reviews', function (Blueprint $table) {
            $table->dropForeign(['prefecture_id']);
            $table->dropColumn('prefecture_id');
        });
    }
};
