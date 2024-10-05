<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('factor_id');
            $table->integer('result');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('factor_id')->references('id')->on('factors')->onDelete('cascade');

            $table->timestamps();
            $table->unique(['user_id', 'factor_id'], 'user_factor_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
};
