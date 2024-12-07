<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryGenerate extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'NameSalary',
        'Status',
        'basic_salary',
        'gross_salary',
        'additions',
        'deductions',
        'net_salary',
        'remarks',
    ];

    public function employee()
    {
        return $this->belongsTo(Emplooyee::class);
    }
    
    public function account() {
        return $this->belongsTo(Account::class);
    }
}
