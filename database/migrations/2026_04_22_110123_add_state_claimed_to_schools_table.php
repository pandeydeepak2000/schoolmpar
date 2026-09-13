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
        $table->string('state')->nullable()->after('city');
        $table->string('area')->nullable()->after('state');
        $table->string('pincode', 10)->nullable()->after('area');
        $table->boolean('is_claimed')->default(false)->after('is_featured');
    });
}

public function down(): void
{
    Schema::table('schools', function (Blueprint $table) {
        $table->dropColumn(['state', 'area', 'pincode', 'is_claimed']);
    });
}
};
