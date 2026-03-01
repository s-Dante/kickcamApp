<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add sport_category
        Schema::table('badges', function (Blueprint $table) {
            $table->string('sport_category')->default('soccer')->after('image_url');
        });

        // Using DB statement directly as altering ENUMs natively isn't fully supported without doctrine/dbal
        // This re-evaluates the array adding 'general' alongside 'flag', 'shield', 'ball', 'fifa_logo', 'poster'
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE badges MODIFY COLUMN type ENUM('general', 'flag', 'shield', 'ball', 'fifa_logo', 'poster') NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('badges', function (Blueprint $table) {
            if (Schema::hasColumn('badges', 'sport_category')) {
                $table->dropColumn('sport_category');
            }
        });

        // Revert ENUM
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE badges MODIFY COLUMN type ENUM('flag', 'shield', 'ball', 'fifa_logo', 'poster') NOT NULL");
        }
    }
};
