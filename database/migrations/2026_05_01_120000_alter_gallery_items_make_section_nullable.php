<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            if (Schema::hasColumn('gallery_items', 'gallery_section_id')) {
                // FK might not exist on all environments; keep safe.
                try {
                    $table->dropForeign(['gallery_section_id']);
                } catch (\Throwable $e) {
                    // ignore
                }

                $table->unsignedBigInteger('gallery_section_id')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            if (Schema::hasColumn('gallery_items', 'gallery_section_id')) {
                $table->unsignedBigInteger('gallery_section_id')->nullable(false)->change();
                $table->foreign('gallery_section_id')->references('id')->on('gallery_sections')->cascadeOnDelete();
            }
        });
    }
};

