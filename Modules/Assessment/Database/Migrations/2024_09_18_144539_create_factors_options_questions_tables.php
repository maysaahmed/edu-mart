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
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->integer('weight');
            $table->timestamps();
        });

        Schema::create('factors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('desc');
            $table->text('low_desc');
            $table->text('moderate_desc');
            $table->text('high_desc');
            $table->string('formula');
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('ques');
            $table->integer('order');
            $table->unsignedBigInteger('factor_id');
            $table->foreign('factor_id')->references('id')->on('factors')->onDelete('cascade');
            $table->index(['factor_id']);
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
        foreach (['options', 'factors', 'questions'] as $tableName) {
            Schema::dropIfExists($tableName);
        }
    }
};
