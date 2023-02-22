<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    // up()：執行 php artisan migrate 時會執行的部分。
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('title');
            $table->string('content');
            $table->timestamps();
        });
    }

    // down()：執行 php artisan migrate:rollback 時會執行的部分。
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};