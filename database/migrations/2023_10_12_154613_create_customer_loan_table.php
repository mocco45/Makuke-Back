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
        Schema::create('customer_loan', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->enum('status', ['pending','approved','rejected','processing'])->default('pending');
            $table->enum('payment_status', ['complete','stilled','ongoing','overpaid'])->default('stilled');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('day_id');
            $table->unsignedBigInteger('interest_id');
            $table->unsignedBigInteger('formfee_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('branch_id')->references('id')->on('branch');
            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
            $table->foreign('interest_id')->references('id')->on('interest')->onDelete('cascade');
            $table->foreign('formfee_id')->references('id')->on('formfee')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_loan');
    }
};
