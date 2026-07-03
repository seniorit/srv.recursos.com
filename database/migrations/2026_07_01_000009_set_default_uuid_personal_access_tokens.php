<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    if (Schema::hasTable('personal_access_tokens')) {
      DB::statement('ALTER TABLE personal_access_tokens ALTER COLUMN id TYPE uuid USING (id::uuid)');
      DB::statement('ALTER TABLE personal_access_tokens ALTER COLUMN id SET DEFAULT gen_random_uuid()');
    }
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    if (Schema::hasTable('personal_access_tokens')) {
      DB::statement('ALTER TABLE personal_access_tokens ALTER COLUMN id DROP DEFAULT');
      DB::statement('ALTER TABLE personal_access_tokens ALTER COLUMN id TYPE character(36) USING (id::text)');
    }
  }
};
