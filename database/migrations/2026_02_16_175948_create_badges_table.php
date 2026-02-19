<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\BadgeTypeEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code')->unique();
            $table->string('image_url');
            $table->enum('type', [
                BadgeTypeEnum::FLAG->value,
                BadgeTypeEnum::SHIELD->value,
                BadgeTypeEnum::BALL->value,
                BadgeTypeEnum::FIFA_LOGO->value,
                BadgeTypeEnum::POSTER->value
            ]);
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
