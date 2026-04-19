<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->unique();

            $table->string('title_am')->nullable();
            $table->string('title_ru')->nullable();
            $table->string('title_en')->nullable();

            $table->text('short_description_am')->nullable();
            $table->text('short_description_ru')->nullable();
            $table->text('short_description_en')->nullable();

            $table->longText('content_am')->nullable();
            $table->longText('content_ru')->nullable();
            $table->longText('content_en')->nullable();

            $table->json('images')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
