<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('exhibition_items', function (Blueprint $table) {
            if (!Schema::hasColumn('exhibition_items', 'secondary_image')) {
                $table->string('secondary_image')->nullable()->after('image');
            }
            if (!Schema::hasColumn('exhibition_items', 'third_image')) {
                $table->string('third_image')->nullable()->after('secondary_image');
            }
            if (!Schema::hasColumn('exhibition_items', 'fourth_image')) {
                $table->string('fourth_image')->nullable()->after('third_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('exhibition_items', function (Blueprint $table) {
            $columns = ['secondary_image', 'third_image', 'fourth_image'];
            $existing = array_values(array_filter($columns, fn (string $c) => Schema::hasColumn('exhibition_items', $c)));
            if ($existing !== []) {
                $table->dropColumn($existing);
            }
        });
    }
};

