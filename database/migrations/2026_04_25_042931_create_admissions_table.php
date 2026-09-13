<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // Student details
            $table->string('student_name');
            $table->date('student_dob');
            $table->enum('student_gender', ['male', 'female', 'other']);
            $table->string('class_applying');

            // Parent details
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->string('parent_email')->nullable();
            $table->text('address');

            // Previous school
            $table->string('previous_school')->nullable();
            $table->string('previous_class')->nullable();
            $table->decimal('previous_percentage', 5, 2)->nullable();

            // Document
            $table->string('document_path')->nullable();

            // Status
            $table->enum('status', [
                'pending',
                'reviewing',
                'approved',
                'rejected'
            ])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};