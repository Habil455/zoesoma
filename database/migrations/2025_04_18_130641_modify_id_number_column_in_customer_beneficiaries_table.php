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
        Schema::table('customer_beneficiaries', function (Blueprint $table) {
            //
            $table->string('id_number', 200)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_beneficiaries', function (Blueprint $table) {
            //
            $table->string('id_number', 200)->nullable()->change();
        });
    }
};
