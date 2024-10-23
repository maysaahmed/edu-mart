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
        Schema::table('accounts', function (Blueprint $table) {
            $table->boolean('graduated')->after('gender')->nullable();
            $table->string('education')->after('graduated')->nullable();
            $table->string('university')->after('education')->nullable();
            $table->string('industry')->after('university')->nullable();
            $table->string('image')->after('industry')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['graduated', 'education', 'university', 'industry', 'image']);
        });
    }
};
