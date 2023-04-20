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

            $table->after('email', function (Blueprint $table) {
                $table->integer('type')->default(1);
                $table->smallInteger('is_active')->default(1);
            });

            $table->foreignId('created_by')->after("created_at")->nullable()->constrained(
                table: 'users', column: 'id'
            );

            $table->foreignId('updated_by')->after("updated_at")->nullable()->constrained(
                table: 'users', column: 'id'
            );

            $table->softDeletes();
            $table->foreignId('deleted_by')->nullable()->constrained(
                table: 'users', column: 'id'
            );
        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['deleted_by']);

            $table->dropSoftDeletes();
            $table->dropColumn(['created_by', 'updated_by', 'deleted_by']);
        });
    }
};
