<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // 'id' カラム (primary key, auto-increment)
            $table->string('user_name');
            $table->text('introduction')->nullable(); // nullable() でNULLを許可
            $table->string('email')->unique(); // unique() でユニーク制約を追加
            $table->string('photo')->nullable();
		    $table->string('avatar')->nullable();
            $table->boolean('is_admin')->default(false); // デフォルト値を設定
            $table->string('password');
            $table->boolean('password_reset')->default(false);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}