<?php

use App\Enums\MultimediaCategoryEnum;
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
        Schema::create('multimedia', function (Blueprint $table) {
            $table->id();
            $table->string('file_url');
            $table->enum('category', [
                MultimediaCategoryEnum::IMAGE,
                MultimediaCategoryEnum::VIDEO,
                MultimediaCategoryEnum::AR,
            ]);
            $table->foreignId('country_id')->constrained('countries', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multimedia');
    }
};
