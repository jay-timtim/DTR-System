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
        Schema::create('attendance_logs', function (Blueprint $table) {

            $table->id();

            // String employee_id foreign key
            $table->string('employee_id');

            $table->timestamp('log_time');
            $table->string('log_type');
            $table->date('log_date');
            $table->string('device_name')->nullable();

            $table->timestamps();

            // Foreign key constraint (PostgreSQL compatible)
            $table->foreign('employee_id')
                ->references('employee_id')
                ->on('employees')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};
