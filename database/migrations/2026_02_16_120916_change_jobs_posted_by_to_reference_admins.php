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
        Schema::table('jobs', function (Blueprint $table) {
            // Drop the old foreign key referencing users
            $table->dropForeign(['posted_by']);

            // Add the new foreign key referencing admins
            $table->foreign('posted_by')->references('id')->on('admins')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Drop the admins foreign key
            $table->dropForeign(['posted_by']);

            // Restore the original foreign key referencing users
            $table->foreign('posted_by')->references('id')->on('users')->nullOnDelete();
        });
    }
};
