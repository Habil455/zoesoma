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
        Schema::create('commission_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('insurance_payments')->onDelete('cascade');
            $table->foreignId('configuration_id')->constrained('commission_configurations')->nullable()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('employees')->onDelete('cascade');
            $table->double('amount')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->boolean('status')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_payments');
    }
};
