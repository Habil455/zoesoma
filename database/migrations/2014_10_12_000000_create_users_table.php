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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('user_code')->nullable();
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('lname')->nullable();
            $table->integer('added_by')->nullable();
            $table->string('phone')->nullable();
            $table->string('emp_id')->nullable();
            $table->string('email', 100)->unique();
            $table->string('username')->nullable();
            $table->string('address')->nullable();
            $table->date('birthdate')->nullable();
            $table->integer('position')->nullable();
            $table->string('job_title')->nullable();
            $table->string('merital_status')->nullable();
            $table->string('password');
            $table->string('photo', 100)->default('/uploads/userprofile/user.png');
            $table->string('nationality')->nullable();
            $table->date('hire_date')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('designation_id')->nullable();
            $table->timestamp('joining_date')->nullable();
            $table->integer('active_status')->nullable();
            $table->integer('disabled')->nullable();
            $table->date('disabled_date')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->date('last_updated')->nullable();
            $table->string('last_login', 20)->nullable();
            $table->integer('status')->default(1)->comment('1=active, 0=inactive');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
