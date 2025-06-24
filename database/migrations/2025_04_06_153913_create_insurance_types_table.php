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
        Schema::create('insurance_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('duration_year');
            $table->integer('duration_days');
            $table->double('price')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_types');
    }
};
