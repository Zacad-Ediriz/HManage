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
        Schema::create('pay_bills', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_id');
            $table->string('balance');
            $table->string('amount_paid');
            $table->string('Description');
            $table->string('TotalBalance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_bills');
    }
};
