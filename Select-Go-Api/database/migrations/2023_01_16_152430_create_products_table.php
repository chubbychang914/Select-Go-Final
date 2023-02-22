<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('pid');
            // 必填欄位
            $table->string('pname')->nullable();
            $table->string('pstyle')->nullable();
            $table->integer('pprice')->null;
            // optional
            $table->string('pinfo')->nullable();
            $table->integer('pcost')->nullable();
            $table->integer('pprofit')->nullable();
            $table->integer('pqty')->nullable();
            $table->integer('psold')->nullable();
            $table->integer('pshelf')->nullable();
            $table->integer('user_id')->nullable();
            // pictures
            $table->binary('ppic_main')->nullable();
            $table->binary('ppic_1')->nullable();
            $table->binary('ppic_2')->nullable();
            $table->binary('ppic_3')->nullable();
            $table->binary('ppic_4')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};