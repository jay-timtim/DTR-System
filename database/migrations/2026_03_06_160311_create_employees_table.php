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
        Schema::create('employees', function (Blueprint $table) {

            $table->id();

            // Employee Information
            $table->string('employee_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('gender')->nullable();
            $table->date('birthday');
            // Contact / Address
            $table->text('address')->nullable();

            // Work Information
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->string('employment_status')->default('regular');
            $table->date('date_hired')->nullable();
            $table->string('basic_salary')->nullable();
            /*
            Examples:
            regular
            probationary
            contractual
            part-time
            */

            // Schedule
            $table->time('schedule_start')->default('09:00:00');
            $table->time('break_start')->default('12:00:00');
            $table->time('break_end')->default('13:00:00');
            $table->time('schedule_end')->default('18:00:00');

            // Employee Photo
            $table->string('photo_path')->nullable();

            // Status
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
