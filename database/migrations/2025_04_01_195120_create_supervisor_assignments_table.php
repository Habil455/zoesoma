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
        Schema::create('supervisor_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supervisor_id')->unsigned()->nullable();
            $table->foreignId('district_id')->unsigned()->nullable();
            $table->foreignId('assigned_by')->unsigned()->nullable();

            // $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
            // $table->foreign('assigned_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisor_assignments');
    }
};
