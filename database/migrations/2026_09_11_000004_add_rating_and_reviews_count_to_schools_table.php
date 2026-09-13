<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            if (!Schema::hasColumn('schools', 'rating')) {
                $table->decimal('rating', 3, 1)->default(4.6)->after('is_featured');
            }
            if (!Schema::hasColumn('schools', 'reviews_count')) {
                $table->unsignedInteger('reviews_count')->default(85)->after('rating');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            if (Schema::hasColumn('schools', 'reviews_count')) {
                $table->dropColumn('reviews_count');
            }
            if (Schema::hasColumn('schools', 'rating')) {
                $table->dropColumn('rating');
            }
        });
    }
};
