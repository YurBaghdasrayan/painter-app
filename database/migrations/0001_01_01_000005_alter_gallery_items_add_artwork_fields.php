<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            if (!Schema::hasColumn('gallery_items', 'slug')) {
                $table->string('slug')->nullable()->unique();
            }

            if (!Schema::hasColumn('gallery_items', 'short_description')) {
                $table->text('short_description')->nullable();
                $table->text('full_description')->nullable();
                $table->string('secondary_image')->nullable();
                $table->string('third_image')->nullable();
                $table->string('fourth_image')->nullable();
                $table->string('same_line_title')->nullable();
                $table->boolean('is_featured_on_home')->default(false)->index();

                // i18n (am/ru/en). Keep base fields as fallback.
                $table->text('short_description_am')->nullable();
                $table->text('short_description_ru')->nullable();
                $table->text('short_description_en')->nullable();
                $table->longText('full_description_am')->nullable();
                $table->longText('full_description_ru')->nullable();
                $table->longText('full_description_en')->nullable();
                $table->string('same_line_title_am')->nullable();
                $table->string('same_line_title_ru')->nullable();
                $table->string('same_line_title_en')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            if (Schema::hasColumn('gallery_items', 'slug')) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            }

            $columns = [
                'short_description',
                'full_description',
                'secondary_image',
                'third_image',
                'fourth_image',
                'same_line_title',
                'is_featured_on_home',
                'short_description_am',
                'short_description_ru',
                'short_description_en',
                'full_description_am',
                'full_description_ru',
                'full_description_en',
                'same_line_title_am',
                'same_line_title_ru',
                'same_line_title_en',
            ];

            $existing = array_values(array_filter($columns, fn (string $c) => Schema::hasColumn('gallery_items', $c)));
            if ($existing !== []) {
                // note: dropping indexed column also drops its index in most DBs
                $table->dropColumn($existing);
            }
        });
    }
};

