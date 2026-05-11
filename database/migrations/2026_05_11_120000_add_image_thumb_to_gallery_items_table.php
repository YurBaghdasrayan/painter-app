<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            if (! Schema::hasColumn('gallery_items', 'image_thumb')) {
                $table->string('image_thumb', 2048)->nullable()->after('image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            if (Schema::hasColumn('gallery_items', 'image_thumb')) {
                $table->dropColumn('image_thumb');
            }
        });
    }
};
