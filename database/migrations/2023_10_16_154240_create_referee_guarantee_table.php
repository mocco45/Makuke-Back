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
        Schema::create('referee_guarantee', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referee_id');
            $table->string('property_name');
            $table->string('photo');
            $table->integer('value');
            $table->string('region');
            $table->string('district');
            $table->string('street');
            $table->timestamps();

            $table->foreign('referee_id')->references('id')->on('referee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referee_guarantee');
    }
};
