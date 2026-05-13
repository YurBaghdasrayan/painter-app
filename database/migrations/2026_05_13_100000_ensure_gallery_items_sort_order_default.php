<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('gallery_items')) {
            return;
        }

        DB::table('gallery_items')->whereNull('sort_order')->update(['sort_order' => 0]);
    }

    public function down(): void
    {
        // no-op
    }
};
