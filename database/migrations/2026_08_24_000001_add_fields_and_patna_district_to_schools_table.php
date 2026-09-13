<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            if (!Schema::hasColumn('schools', 'district')) {
                $table->string('district')->default('Patna')->after('city');
            }
            if (!Schema::hasColumn('schools', 'image_url')) {
                $table->text('image_url')->nullable()->after('description');
            }
            if (!Schema::hasColumn('schools', 'banner_image')) {
                $table->string('banner_image')->nullable()->after('image_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            if (Schema::hasColumn('schools', 'district')) {
                $table->dropColumn('district');
            }
            if (Schema::hasColumn('schools', 'image_url')) {
                $table->dropColumn('image_url');
            }
            if (Schema::hasColumn('schools', 'banner_image')) {
                $table->dropColumn('banner_image');
            }
        });
    }
};
