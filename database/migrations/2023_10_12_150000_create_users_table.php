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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('maritalStatus');
            $table->bigInteger('phone');
            $table->string('photo')->nullable();
            $table->string('gender');
            $table->string('street');
            $table->string('district');
            $table->string('region');
            $table->integer('age');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('financials_id');
            $table->foreign('role_id')->references('id')->on('role');
            $table->foreign('branch_id')->references('id')->on('branch');
            $table->foreign('financials_id')->references('id')->on('financials');
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
