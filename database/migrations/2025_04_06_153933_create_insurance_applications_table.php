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
        Schema::create('insurance_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('insurance_type');
            $table->unsignedBigInteger('insurance_term')->nullable();
            $table->string('purpose')->nullable();
            $table->double('monthly_payment')->nullable();
            $table->double('expected_amount')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->integer('status')->default(1);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('insurance_type')->references('id')->on('insurance_types')->onDelete('cascade');
            $table->foreign('insurance_term')->references('id')->on('insurance_terms')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_applications');
    }
};
