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
        Schema::create('doctor', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->string('Department');
            $table->string('Specialist');
            $table->string('Doctore_Experience');
            $table->date('Birth_date');
            $table->string('Sex');
            $table->string('Blood_group');
            $table->string('Address');
            $table->integer('Doctore_phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor');
    }
};
