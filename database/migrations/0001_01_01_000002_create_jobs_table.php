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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 160)->index();
            $table->longText('description');
            // Direct category is optional
            $table->foreignId('category_id')->nullable()->constrained()->restrictOnDelete();
            // Sub-category is now optional as well
            $table->foreignId('sub_category_id')->nullable()->constrained()->restrictOnDelete();
            $table->string('company', 160)->index();
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('location', 160)->index();
            $table->enum('level', ['entry', 'mid', 'senior', 'executive'])->index();
            $table->date('deadline')->index();
            $table->boolean('is_active')->default(true)->index();
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active')->after('is_active');
            $table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            // Add indexes for foreign keys
            $table->index('category_id');
            $table->index('sub_category_id');
            $table->index('posted_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
