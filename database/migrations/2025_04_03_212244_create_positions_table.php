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
            Schema::create('positions', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('code', 10)->nullable();
                $table->integer('dept_id')->index('department_fk');
                $table->string('dept_code', 5)->default('001');
                $table->integer('organization_level')->nullable();
                $table->string('purpose', 300)->default('N/A');
                $table->string('minimum_qualification', 200)->default('N/A');
                $table->integer('driving_licence')->default(0);
                $table->string('created_by', 50)->nullable();
                $table->dateTime('created_on')->useCurrent();
                $table->integer('state')->default(1);
                $table->integer('isLinked')->default(1);
                $table->string('position_code', 10)->default('0');
                $table->string('parent_code', 10)->default('0');
                $table->integer('level')->nullable();
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
