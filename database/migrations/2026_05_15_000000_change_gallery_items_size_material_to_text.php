<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            foreach ([
                'size',
                'material',
                'size_am',
                'size_ru',
                'size_en',
                'material_am',
                'material_ru',
                'material_en',
            ] as $column) {
                if (Schema::hasColumn('gallery_items', $column)) {
                    $table->text($column)->nullable()->change();
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            foreach ([
                'size',
                'material',
                'size_am',
                'size_ru',
                'size_en',
                'material_am',
                'material_ru',
                'material_en',
            ] as $column) {
                if (Schema::hasColumn('gallery_items', $column)) {
                    $table->string($column)->nullable()->change();
                }
            }
        });
    }
};
