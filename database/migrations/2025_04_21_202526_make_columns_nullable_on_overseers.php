<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('overseers', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['id_type']);
            $table->text('id_number')->nullable()->change();

            // Make the column nullable
            $table->unsignedBigInteger('id_type')->nullable()->change();


            // Re-apply the foreign key constraint
            $table->foreign('id_type')->references('id')->on('identification_types')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('overseers', function (Blueprint $table) {
            $table->dropForeign(['id_type']);
            $table->integer('id_number');
            $table->unsignedBigInteger('id_type')->nullable(false)->change();
            $table->foreign('id_type')->references('id')->on('identification_types')->onDelete('cascade');
        });
    }
};
