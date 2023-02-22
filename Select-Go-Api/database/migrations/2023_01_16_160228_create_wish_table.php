<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wish', function (Blueprint $table) {
            $table->id();
            // mandatory
            $table->string('wname');
            $table->string('winfo');
            $table->string('wstyle');
            $table->string('wpic_main');
            $table->string('wstatus')->default('集氣中');
            // optional
            $table->string('wweb')->nullable();
            $table->string('wppic_1')->nullable();
            $table->string('wppic_2')->nullable();
            $table->string('wppic_3')->nullable();
            $table->string('wppic_4')->nullable();
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
        Schema::dropIfExists('wish');
    }
};
