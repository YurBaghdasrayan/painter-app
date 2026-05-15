<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

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
                DB::statement("ALTER TABLE gallery_items MODIFY `{$column}` TEXT NULL");
            }
        }
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

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
                DB::statement("ALTER TABLE gallery_items MODIFY `{$column}` VARCHAR(255) NULL");
            }
        }
    }
};
