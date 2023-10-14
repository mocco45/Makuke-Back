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
            $table->integer('repayment_time');
            $table->integer('interest_rate');
            $table->enum('status', ['pending','approved','rejected','manager_approved'])->default('pending');
            $table->enum('payment_status', ['complete','stilled','ongoing','overpaid'])->default('stilled');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('branch_id')->references('id')->on('branch');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
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
