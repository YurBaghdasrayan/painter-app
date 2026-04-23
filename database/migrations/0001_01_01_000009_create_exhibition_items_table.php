<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('exhibition_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exhibition_id')
                ->constrained('exhibitions')
                ->cascadeOnDelete();

            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            // i18n (am/ru/en). Keep base fields as fallback.
            $table->string('title_am')->nullable();
            $table->string('title_ru')->nullable();
            $table->string('title_en')->nullable();
            $table->text('description_am')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_en')->nullable();

            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();

            $table->index(['exhibition_id', 'is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exhibition_items');
    }
};

