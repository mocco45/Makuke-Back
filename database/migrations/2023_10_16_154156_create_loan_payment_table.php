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
        Schema::create('loan_payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_loan_id');
            $table->integer('amount');
            $table->string('type');
            $table->string('payment_method')->default('cash');
            $table->unsignedBigInteger('request_delay_id')->default(null);
            $table->timestamps();

            $table->foreign('request_delay_id')->references('id')->on('request_delay');
            $table->foreign('customer_loan_id')->references('id')->on('customer_loan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_payment');
    }
};
