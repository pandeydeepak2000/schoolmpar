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
        $table->enum('admission_status', ['open', 'closed', 'coming_soon'])
              ->default('open')->after('status');
        $table->date('admission_open_date')->nullable()->after('admission_status');
        $table->date('admission_close_date')->nullable()->after('admission_open_date');
        $table->integer('seats_available')->nullable()->after('admission_close_date');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            //
        });
    }
};
