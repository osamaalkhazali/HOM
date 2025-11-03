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
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->enum('document_type', [
                'warning',
                'appreciation',
                'medical',
                'contract',
                'evaluation',
                'promotion',
                'resignation',
                'other'
            ])->default('other');
            $table->string('document_name');
            $table->string('file_path');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Add index for better query performance
            $table->index('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_documents');
    }
};
