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
        Schema::create('salary_list', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('employee_id'); // Foreign key for employees
            $table->string('NameSalary'); // Salary name or description
            $table->decimal('net_salary', 10, 2); // Net salary amount
            $table->boolean('Status')->default(0); // Status: 0 for pending, 1 for paid
            $table->timestamps(); // created_at and updated_at timestamps

            // Define foreign key constraint
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_list');
    }
};
