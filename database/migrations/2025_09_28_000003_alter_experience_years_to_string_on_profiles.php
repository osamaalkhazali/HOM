<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    // Change experience_years from integer to string to store ranges like '0-1','2-3','4-5','6-10','10+'
    Schema::table('profiles', function (Blueprint $table) {
      $table->string('experience_years', 10)->nullable()->change();
    });
  }

  public function down(): void
  {
    // Revert back to integer if needed
    Schema::table('profiles', function (Blueprint $table) {
      $table->integer('experience_years')->nullable()->change();
    });
  }
};
