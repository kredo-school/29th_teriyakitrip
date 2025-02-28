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
        Schema::create('prefectures', function (Blueprint $table) {
            $table->id(); // 自動インクリメントの主キー
            $table->string('name'); // 都道府県名 (VARCHAR)
            $table->unsignedBigInteger('region_id'); // 地域ID (外部キー)
            $table->string('color')->nullable(); // カラーコード (NULL許容)

            // 外部キー制約
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prefectures');
    }
};
