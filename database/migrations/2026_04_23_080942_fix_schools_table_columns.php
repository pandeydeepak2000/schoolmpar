<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            // is_active column add karo
            $table->boolean('is_active')->default(true)->after('status');
        });

        // Status enum mein 'approved' aur 'rejected' add karo
        DB::statement("ALTER TABLE schools MODIFY COLUMN status ENUM('active','inactive','pending','approved','rejected') DEFAULT 'pending'");

        // Existing 'active' schools ko 'approved' mark karo
        DB::statement("UPDATE schools SET status = 'approved' WHERE status = 'active'");
        DB::statement("UPDATE schools SET is_active = 1");
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
        DB::statement("ALTER TABLE schools MODIFY COLUMN status ENUM('active','inactive','pending') DEFAULT 'pending'");
    }
};