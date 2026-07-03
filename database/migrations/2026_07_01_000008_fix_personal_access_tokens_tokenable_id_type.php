<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    if (Schema::hasTable('personal_access_tokens') && Schema::hasColumn('personal_access_tokens', 'tokenable_id')) {
      Schema::table('personal_access_tokens', function (Blueprint $table) {
        $table->dropIndex(['tokenable_type', 'tokenable_id']);
      });

      Schema::table('personal_access_tokens', function (Blueprint $table) {
        $table->dropColumn('tokenable_id');
      });

      Schema::table('personal_access_tokens', function (Blueprint $table) {
        $table->uuidCompat('tokenable_id')->after('id');
        $table->index(['tokenable_type', 'tokenable_id']);
      });
    }
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    if (Schema::hasTable('personal_access_tokens') && Schema::hasColumn('personal_access_tokens', 'tokenable_id')) {
      Schema::table('personal_access_tokens', function (Blueprint $table) {
        $table->dropIndex(['tokenable_type', 'tokenable_id']);
      });

      Schema::table('personal_access_tokens', function (Blueprint $table) {
        $table->dropColumn('tokenable_id');
      });

      Schema::table('personal_access_tokens', function (Blueprint $table) {
        $table->bigInteger('tokenable_id')->unsigned()->after('id');
        $table->index(['tokenable_type', 'tokenable_id']);
      });
    }
  }
};
