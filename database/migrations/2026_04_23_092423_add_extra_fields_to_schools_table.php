<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {

            // ✅ Sirf wo columns jo exist NAHI karte
            if (!Schema::hasColumn('schools', 'state'))
                $table->string('state')->nullable()->after('city');

            if (!Schema::hasColumn('schools', 'school_type'))
                $table->string('school_type')->nullable()->after('medium');

            if (!Schema::hasColumn('schools', 'established_year'))
                $table->unsignedSmallInteger('established_year')->nullable()->after('school_type');

            if (!Schema::hasColumn('schools', 'total_students'))
                $table->unsignedInteger('total_students')->nullable()->after('established_year');

            if (!Schema::hasColumn('schools', 'principal_name'))
                $table->string('principal_name')->nullable()->after('total_students');

            if (!Schema::hasColumn('schools', 'affiliation_no'))
                $table->string('affiliation_no')->nullable()->after('principal_name');

            if (!Schema::hasColumn('schools', 'admission_status'))
                $table->enum('admission_status', ['open','closed','coming_soon'])->default('open')->after('class_to');

            if (!Schema::hasColumn('schools', 'admission_open_date'))
                $table->date('admission_open_date')->nullable()->after('admission_status');

            if (!Schema::hasColumn('schools', 'admission_close_date'))
                $table->date('admission_close_date')->nullable()->after('admission_open_date');

            if (!Schema::hasColumn('schools', 'seats_available'))
                $table->unsignedInteger('seats_available')->nullable()->after('admission_close_date');

            if (!Schema::hasColumn('schools', 'admission_fee'))
                $table->unsignedInteger('admission_fee')->nullable()->after('seats_available');

            if (!Schema::hasColumn('schools', 'transport_fee'))
                $table->unsignedInteger('transport_fee')->nullable()->after('fee_max');

            if (!Schema::hasColumn('schools', 'facilities'))
                $table->json('facilities')->nullable()->after('transport_fee');

            if (!Schema::hasColumn('schools', 'owner_id'))
                $table->unsignedBigInteger('owner_id')->nullable()->after('id');

            if (!Schema::hasColumn('schools', 'is_claimed'))
                $table->boolean('is_claimed')->default(false)->after('is_featured');
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $columns = [
                'state', 'school_type', 'established_year', 'total_students',
                'principal_name', 'affiliation_no',
                'admission_status', 'admission_open_date', 'admission_close_date',
                'seats_available', 'admission_fee', 'transport_fee',
                'facilities', 'owner_id', 'is_claimed',
            ];

            foreach ($columns as $col) {
                if (Schema::hasColumn('schools', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};