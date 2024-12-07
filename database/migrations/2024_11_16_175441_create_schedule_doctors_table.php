<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('schedule_doctors', function (Blueprint $table) {
            $table->id();
            $table->string('schedule_name');
            $table->foreignId('doctor_id')->constrained('doctor')->onDelete('cascade'); // Assuming doctors are users
            $table->string('day');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('fees', 10, 2);
            $table->integer('number_of_visits');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_doctors');
    }
};
