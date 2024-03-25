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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->date('incomeDate'); 
            $table->string('incomeAmount');
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('payment_type_id');
            $table->unsignedBigInteger('account_name_id');
            $table->unsignedBigInteger('account_category_id');
            $table->foreign('payment_method_id')->references('id')->on('payment_method')->onDelete('cascade');
            $table->foreign('payment_type_id')->references('id')->on('payment_type')->onDelete('cascade');
            $table->foreign('account_name_id')->references('id')->on('account_names')->onDelete('cascade');
            $table->foreign('account_category_id')->references('id')->on('account_category')->onDelete('cascade');
            $table->string('incomeDescription');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
