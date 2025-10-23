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
        Schema::create('job_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->string('question', 500);
            $table->string('question_ar', 500)->nullable();
            $table->boolean('is_required')->default(true);
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->timestamps();
        });

        Schema::create('job_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->string('name', 255);
            $table->string('name_ar', 255)->nullable();
            $table->boolean('is_required')->default(true);
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->timestamps();
        });

        Schema::create('application_question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_question_id')->constrained('job_questions')->cascadeOnDelete();
            $table->text('answer');
            $table->timestamps();
        });

        Schema::create('application_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_document_id')->constrained('job_documents')->cascadeOnDelete();
            $table->string('file_path', 255);
            $table->string('original_name', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_documents');
        Schema::dropIfExists('application_question_answers');
        Schema::dropIfExists('job_documents');
        Schema::dropIfExists('job_questions');
    }
};

