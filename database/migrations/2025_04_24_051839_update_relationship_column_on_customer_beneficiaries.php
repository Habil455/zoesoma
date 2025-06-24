<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('customer_beneficiaries', function (Blueprint $table) {
            $table->dropUnique(['relationship']); // remove unique constraint
            $table->string('relationship')->nullable()->change(); // make sure the column is nullable and no longer unique
        });
    }

    public function down()
    {
        Schema::table('customer_beneficiaries', function (Blueprint $table) {
            $table->string('relationship')->unique()->nullable()->change(); // rollback
        });
    }
};
