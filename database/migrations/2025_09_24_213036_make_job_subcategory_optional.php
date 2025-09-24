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
            // Add direct category relationship
            $table->foreignId('category_id')->nullable()->constrained()->restrictOnDelete()->after('description');

            // Make subcategory optional
            $table->foreignId('sub_category_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Drop the category_id column
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');

            // Make subcategory required again
            $table->foreignId('sub_category_id')->nullable(false)->change();
        });
    }
};
