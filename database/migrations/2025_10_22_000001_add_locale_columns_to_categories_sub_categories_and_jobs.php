<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name_ar')->nullable()->after('name');
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->string('name_ar')->nullable()->after('name');
        });

        Schema::table('jobs', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title');
            $table->longText('description_ar')->nullable()->after('description');
            $table->string('company_ar', 160)->nullable()->after('company');
            $table->string('location_ar', 160)->nullable()->after('location');
        });
    }

    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'description_ar', 'company_ar', 'location_ar']);
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropColumn(['name_ar']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['name_ar', 'description_ar']);
        });
    }
};
