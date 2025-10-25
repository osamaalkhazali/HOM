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
    Schema::create('application_document_requests', function (Blueprint $table) {
      $table->id();
      $table->foreignId('application_id')->constrained()->cascadeOnDelete();
      $table->string('name')->comment('Document name in English');
      $table->string('name_ar')->nullable()->comment('Document name in Arabic');
      $table->text('notes')->nullable();
            $table->string('file_path')->nullable();
            $table->string('original_name')->nullable();
      $table->boolean('is_submitted')->default(false);
      $table->timestamp('submitted_at')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('application_document_requests');
  }
};
