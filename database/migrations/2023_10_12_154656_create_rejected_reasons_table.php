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
        Schema::create('rejected_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('reasons');
            $table->unsignedBigInteger('customer_loan_id');
            $table->foreign('customer_loan_id')->references('id')->on('customer_loan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rejected_reasons');
    }
};
