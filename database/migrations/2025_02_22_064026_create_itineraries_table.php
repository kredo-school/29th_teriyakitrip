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
        Schema::create('itineraries', function (Blueprint $table) {
            $table->id(); // PK, INT, auto-increment
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
// FK, INT, usersテーブルのidカラムを参照//Edited by Sunao->nullable&onDelete//
            $table->string('title'); // VARCHAR
            $table->date('start_date')->nullable(); // DATE
            $table->date('end_date')->nullable(); // DATE
            $table->boolean('is_public')->default(false); // BOOLEAN
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
        Schema::dropIfExists('itineraries');
    }
};