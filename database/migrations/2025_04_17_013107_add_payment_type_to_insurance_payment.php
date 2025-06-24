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
        Schema::table('insurance_payments', function (Blueprint $table) {
            if (!Schema::hasColumn('insurance_payments', 'attachment')) {
                $table->string('attachment')->after('payment_amount')->nullable();
            }

            if (!Schema::hasColumn('insurance_payments', 'payment_type')) {
                $table->unsignedBigInteger('payment_type')->nullable()->after('application_id');
                $table->foreign('payment_type')->references('id')->on('payment_types');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insurance_payments', function (Blueprint $table) {
            //
        });
    }
};
