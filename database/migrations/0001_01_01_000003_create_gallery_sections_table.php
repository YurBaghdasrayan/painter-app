<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gallery_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('left_text')->nullable();
            $table->text('right_text')->nullable();
            $table->string('more_button_text')->default('more');

            // i18n (am/ru/en). Keep base fields as fallback.
            $table->string('title_am')->nullable();
            $table->string('title_ru')->nullable();
            $table->string('title_en')->nullable();
            $table->text('left_text_am')->nullable();
            $table->text('left_text_ru')->nullable();
            $table->text('left_text_en')->nullable();
            $table->text('right_text_am')->nullable();
            $table->text('right_text_ru')->nullable();
            $table->text('right_text_en')->nullable();
            $table->string('more_button_text_am')->nullable();
            $table->string('more_button_text_ru')->nullable();
            $table->string('more_button_text_en')->nullable();

            $table->boolean('is_active')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_sections');
    }
};

