<?php

namespace App\Models;

use App\Models\patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment_form extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient',
        'amount',
        'amount_paid',
        'balance',
        'paybills_method_id',
       
    ];
    public function mypatient()
    {
        return $this->belongsTo(patient::class, 'patient');
    }


}
