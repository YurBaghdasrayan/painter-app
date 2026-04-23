<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('collection_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_section_id')
                ->constrained('collection_sections')
                ->cascadeOnDelete();

            $table->string('slug')->unique();

            $table->string('title')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->string('same_line_title')->nullable();

            // images
            $table->string('image');
            $table->string('secondary_image')->nullable();
            $table->string('third_image')->nullable();
            $table->string('fourth_image')->nullable();

            // i18n (am/ru/en). Keep base fields as fallback.
            $table->string('title_am')->nullable();
            $table->string('title_ru')->nullable();
            $table->string('title_en')->nullable();
            $table->text('short_description_am')->nullable();
            $table->text('short_description_ru')->nullable();
            $table->text('short_description_en')->nullable();
            $table->longText('full_description_am')->nullable();
            $table->longText('full_description_ru')->nullable();
            $table->longText('full_description_en')->nullable();
            $table->string('same_line_title_am')->nullable();
            $table->string('same_line_title_ru')->nullable();
            $table->string('same_line_title_en')->nullable();

            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_featured_on_home')->default(false)->index();
            $table->timestamps();

            // Explicit short index name for MySQL identifier limit
            $table->index(['collection_section_id', 'is_active', 'sort_order'], 'col_items_sec_active_sort_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collection_items');
    }
};

