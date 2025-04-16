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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('assessment_type', ['soft', 'technical']);
            $table->text('desc');
            $table->integer('mcq_points')->nullable(); //points per mcq question
            $table->integer('t/f_points')->nullable(); //points per true/false question
            $table->integer('sb_points')->nullable(); //points per scenario based question
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('organization_assessment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('assessment_id');
            $table->integer('limit_users');

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('assessment_id')->references('id')->on('assessments')->onDelete('cascade');

            $table->timestamps();
            $table->unique(['organization_id', 'assessment_id'], 'organization_assessment_unique');
        });

        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->text('ques');
            $table->unsignedBigInteger('assessment_id');
            $table->enum('question_type', ['mcq', 't/f', 'sb']);
            $table->foreign('assessment_id')->references('id')->on('assessments')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('assessment_answers', function (Blueprint $table) {
            $table->id();
            $table->text('answer_text')->nullable();
            $table->boolean('is_correct')->default(false); // for MCQs and True/False
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('assessment_questions')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('assessment_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('evaluation');
            $table->integer('from')->default(0);
            $table->integer('to')->default(0);
            $table->unsignedBigInteger('assessment_id');
            $table->foreign('assessment_id')->references('id')->on('assessments')->onDelete('cascade');
            $table->text('desc')->nullable();
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
        $tables = [
            'assessments',
            'organization_assessment',
            'assessment_questions',
            'assessment_answers',
            'assessment_tiers',
        ];

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
