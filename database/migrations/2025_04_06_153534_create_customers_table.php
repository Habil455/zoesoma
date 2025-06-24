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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 20)->nullable();
            $table->string('middle_name', 20)->nullable();
            $table->string('last_name', 20)->nullable();
            $table->string('phone_number', 20)->unique()->nullable();
            $table->string('gender', 8)->nullable();
            $table->string('email', 50)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->string('occupation',20)->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('id_type')->nullable();
            $table->integer('id_number')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('id_type')->references('id')->on('identification_types')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
