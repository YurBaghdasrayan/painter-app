<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pictures_and_videos', function (Blueprint $table) {
            $table->id();

            // JSON array of items:
            // [
            //   { id, type(photo|video), image, video_url?, description_am, description_ru, description_en }
            // ]
            $table->json('items')->nullable();

            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pictures_and_videos');
    }
};

