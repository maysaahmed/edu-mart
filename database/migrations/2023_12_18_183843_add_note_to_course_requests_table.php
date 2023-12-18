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
        Schema::table('course_requests', function (Blueprint $table) {
            $table->integer('status')->default(0)->comment('0 -> new, 1 -> approved, 2 -> rejected, 3 -> canceled, 4 -> booked, 5 -> archived')->change();
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_requests', function (Blueprint $table) {
            $table->integer('status')->default(0)->comment('0 -> new, 1 -> approved, 2 -> rejected')->change();
            $table->dropColumn('note');
        });
    }
};
