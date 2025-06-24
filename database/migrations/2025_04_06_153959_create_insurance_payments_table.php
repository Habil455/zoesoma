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
        Schema::create('insurance_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id');
            // $table->foreignId('')->nullable();
            $table->text('description')->nullable();
            $table->double('payment_amount');
            $table->timestamp('payment_date');
            $table->boolean('status');
            $table->foreignId('created_by');
            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('insurance_applications')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('employees')->onDelete('cascade');
            // $table->foreign('')->references('id')->on('')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_payments');
    }
};
