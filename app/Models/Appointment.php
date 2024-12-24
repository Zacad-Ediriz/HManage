<?php

namespace App\Models;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'appointment_time',
        'serial',
        'doctor',
        'schedule',
        'patient',
        'consultant_fee',
        'discount',
        'net_fee',
        'payment_status',
        'remark',
    ];
    
    
    
    
    
    public function mypi()
    {
        return $this->belongsTo(Doctor::class, 'doctor'); // Ensure 'doctor_id' matches your database column
    }

    // Relationship with Patient
    public function pp()
    {
        return $this->belongsTo(Patient::class, 'patient');
    }
}
