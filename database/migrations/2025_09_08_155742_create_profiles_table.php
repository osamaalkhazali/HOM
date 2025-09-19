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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('headline', 160)->nullable();
            $table->string('location', 160)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('linkedin_url', 255)->nullable();
            $table->string('education', 255)->nullable(); // University/School name
            $table->string('current_position', 160)->nullable(); // Current job title
            $table->integer('experience_years')->nullable(); // Years of experience
            $table->text('skills')->nullable(); // Skills (comma separated or JSON)
            $table->text('about')->nullable();
            $table->string('cv_path', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
