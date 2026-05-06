<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            if (!Schema::hasColumn('gallery_items', 'size')) {
                $table->string('size')->nullable()->after('same_line_title');
            }
            if (!Schema::hasColumn('gallery_items', 'material')) {
                $table->string('material')->nullable()->after('size');
            }

            if (!Schema::hasColumn('gallery_items', 'size_am')) {
                $table->string('size_am')->nullable()->after('size');
                $table->string('size_ru')->nullable()->after('size_am');
                $table->string('size_en')->nullable()->after('size_ru');
            }

            if (!Schema::hasColumn('gallery_items', 'material_am')) {
                $table->string('material_am')->nullable()->after('material');
                $table->string('material_ru')->nullable()->after('material_am');
                $table->string('material_en')->nullable()->after('material_ru');
            }
        });
    }

    public function down(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            $columns = [
                'size',
                'material',
                'size_am',
                'size_ru',
                'size_en',
                'material_am',
                'material_ru',
                'material_en',
            ];

            $existing = array_values(array_filter($columns, fn (string $c) => Schema::hasColumn('gallery_items', $c)));
            if ($existing !== []) {
                $table->dropColumn($existing);
            }
        });
    }
};

