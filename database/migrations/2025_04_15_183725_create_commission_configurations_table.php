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
        Schema::create('commission_configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_type_id')->constrained('payment_types')->onDelete('cascade');
            $table->double('amount')->nullable();
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade')->nullable();
            $table->foreignId('added_by')->constrained('employees')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_configurations');
    }
};
