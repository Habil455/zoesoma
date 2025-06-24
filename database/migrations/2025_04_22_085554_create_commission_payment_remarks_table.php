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
        Schema::create('commission_payment_remarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commission_payment_id')->constrained('commission_payments')->onDelete('cascade');
            $table->string('remarked_by')->nullable();
            $table->text('remark')->nullable();
            $table->foreignId('created_by')->constrained('employees')->nullable()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_payment_remarks');
    }
};
