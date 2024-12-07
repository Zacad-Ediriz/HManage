<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryList extends Model
{
    use HasFactory;
   
    protected $table = 'salary_lists';
    protected $fillable = [
        'employee_name', 
        'NameSalary',// Name of the employee
        'net_salary',     // Paid salary amount
        'Status',         // Payment status: 1 = Paid
        'account_id',     // Account used for payment// 0 for pending, 1 for paid
       
    ];
    public function employee()
    {
        return $this->belongsTo(Emplooyee::class, 'employee_id');
    }
   
    // Relationship with Account
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
    
    

    
}
