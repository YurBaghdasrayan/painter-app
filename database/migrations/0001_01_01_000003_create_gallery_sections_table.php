<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gallery_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('left_text')->nullable();
            $table->text('right_text')->nullable();
            $table->string('more_button_text')->default('more');
            $table->boolean('is_active')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_sections');
    }
};

