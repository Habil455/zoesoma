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
        if (!Schema::hasColumn('commission_payments', 'approved_by')) {
            Schema::table('commission_payments', function (Blueprint $table) {
            //
            $table->foreignId('approved_by')->nullable()->constrained()->onDelete('set null');
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commission_payments', function (Blueprint $table) {
            //
        });
    }
};
