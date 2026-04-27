<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pictures_and_videos', function (Blueprint $table) {
            if (!Schema::hasColumn('pictures_and_videos', 'content')) {
                $table->json('content')->nullable()->after('items');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pictures_and_videos', function (Blueprint $table) {
            if (Schema::hasColumn('pictures_and_videos', 'content')) {
                $table->dropColumn('content');
            }
        });
    }
};

