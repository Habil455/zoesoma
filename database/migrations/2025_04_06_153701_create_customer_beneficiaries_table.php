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
        if (!Schema::hasTable('customer_beneficiaries')) {
            Schema::create('customer_beneficiaries', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('customer_id');
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('phone_number')->unique()->nullable();
                $table->string('relationship')->unique()->nullable();
                $table->unsignedBigInteger('id_type')->nullable();
                $table->integer('id_number')->nullable();
                $table->timestamps();

                $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
                $table->foreign('id_type')->references('id')->on('identification_types')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_beneficiaries');
    }
};
