<?php

namespace App\Models;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable=[
      'name',
      'phone',
      'sex',
      'address',
      'balance',
      'remarks',
    ];
    public function scheduless()
    {
        return $this->hasMany(ScheduleDoctor::class);
    }
    
        public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient');
    }
        
    
   
}
