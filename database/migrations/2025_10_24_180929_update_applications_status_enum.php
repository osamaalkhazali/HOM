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
        DB::statement("ALTER TABLE `applications` MODIFY COLUMN `status` ENUM('pending', 'under_reviewing', 'reviewed', 'shortlisted', 'documents_requested', 'documents_submitted', 'rejected', 'hired') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `applications` MODIFY COLUMN `status` ENUM('pending', 'reviewed', 'shortlisted', 'rejected', 'hired') NOT NULL DEFAULT 'pending'");
    }
};
