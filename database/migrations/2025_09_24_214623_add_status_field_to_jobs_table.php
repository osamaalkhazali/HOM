<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Add status field with enum values
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active')->after('is_active');

            // Migrate existing data: if is_active = 1 then 'active', else 'inactive'
            // We'll handle this in a separate step after adding the column
        });

        // Update existing records based on is_active field
        DB::statement("UPDATE jobs SET status = CASE WHEN is_active = 1 THEN 'active' ELSE 'inactive' END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
