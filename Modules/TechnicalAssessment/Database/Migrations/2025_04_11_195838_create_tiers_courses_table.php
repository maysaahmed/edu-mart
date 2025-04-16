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
        Schema::create('tiers_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tier_id');
            $table->unsignedBigInteger('course_id');

            $table->foreign('tier_id')->references('id')->on('assessment_tiers')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');

            $table->timestamps();
            $table->unique(['tier_id', 'course_id'], 'tier_course_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiers_courses');
    }
};
