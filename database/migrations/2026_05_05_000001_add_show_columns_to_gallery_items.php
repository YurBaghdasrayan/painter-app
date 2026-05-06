<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            if (!Schema::hasColumn('gallery_items', 'show_columns_am')) {
                $table->json('show_columns_am')->nullable()->after('material_en');
            }
            if (!Schema::hasColumn('gallery_items', 'show_columns_ru')) {
                $table->json('show_columns_ru')->nullable()->after('show_columns_am');
            }
            if (!Schema::hasColumn('gallery_items', 'show_columns_en')) {
                $table->json('show_columns_en')->nullable()->after('show_columns_ru');
            }
        });
    }

    public function down(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            $cols = ['show_columns_am', 'show_columns_ru', 'show_columns_en'];
            $existing = array_values(array_filter($cols, fn (string $c) => Schema::hasColumn('gallery_items', $c)));
            if ($existing !== []) {
                $table->dropColumn($existing);
            }
        });
    }
};

