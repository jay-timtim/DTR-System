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
        Schema::table('deduction_settings', function (Blueprint $table) {
            $table->decimal('pagibig_deduction', 8, 2)->default(0.00)->after('undertime_rate_per_minute');
            $table->decimal('sss_deduction', 8, 2)->default(0.00)->after('pagibig_deduction');
            $table->decimal('philhealth_deduction', 8, 2)->default(0.00)->after('sss_deduction');
            $table->decimal('other_deductions', 8, 2)->default(0.00)->after('philhealth_deduction');
        });
    }

    public function down(): void
    {
        Schema::table('deduction_settings', function (Blueprint $table) {
            $table->dropColumn(['pagibig_deduction', 'sss_deduction', 'philhealth_deduction', 'other_deductions']);
        });
    }
};
