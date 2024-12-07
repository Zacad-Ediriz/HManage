<?php

// app/Models/Employee.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emplooyee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'date_of_birth', 'phone_number', 'email', 'nid',
        'blood_group', 'department_id', 'position_id', 'joining_date',
        'gender', 'guarantor_name', 'guarantor_email', 'guarantor_relation',
        'emergency_contact', 'emergency_address', 'basic_salary',
        'gross_salary', 'additions', 'deductions'
    ];

    // Relationships
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function salaryStructures()
    {
        return $this->hasMany(SalaryStructure::class);
    }
}
