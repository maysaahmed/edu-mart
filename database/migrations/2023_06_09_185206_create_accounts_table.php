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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable()->after('type')->comment('only for managers and users');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');

        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('job_title')->nullable();
            $table->string('area')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('gender')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('organization_id');
        });
    }
};
