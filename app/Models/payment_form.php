<?php

namespace App\Models;

use App\Models\patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class payment_form extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient',
        'balance',
        'amount_paid',
        'invoice',
        'amount',
        'payment_method',
        'appointment_status'
    ];
    public function mypatient()
    {
        return $this->belongsTo(patient::class, 'patient');
    }


}
