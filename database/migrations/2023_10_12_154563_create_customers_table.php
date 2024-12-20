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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('otherName')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('gender');
            $table->string('photo')->nullable();
            $table->string('marital_status');
            $table->integer('phone');
            $table->bigInteger('nida');
            $table->string('region');
            $table->string('district');
            $table->string('street');
            $table->string('occupation');
            $table->string('branch_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
