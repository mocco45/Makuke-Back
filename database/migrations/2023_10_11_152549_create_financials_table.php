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
        Schema::create('financials', function (Blueprint $table) {
            $table->id();
            $table->integer('basicSalary');
            $table->integer('bankAccount');
            $table->string('bankAccountHolderName');
            $table->string('bankName');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financials');
    }
};
