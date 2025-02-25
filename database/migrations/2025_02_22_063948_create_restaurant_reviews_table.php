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
        Schema::create('restaurant_reviews', function (Blueprint $table) {
            $table->id(); // PK, INT, auto-increment
            $table->foreignId('user_id')->constrained('users'); // FK, INT, usersテーブルのidカラムを参照
            $table->string('place_id')->nullable(); // VARCHAR
            $table->integer('rating')->nullable(); // INTEGER
            $table->string('title'); // VARCHAR
            $table->text('body'); // TEXT
            $table->string('photo')->nullable(); // VARCHAR
            $table->timestamps(); // created_at, updated_at (TIMESTAMP)
            $table->softDeletes(); // deleted_at (TIMESTAMP)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_reviews');
    }
};