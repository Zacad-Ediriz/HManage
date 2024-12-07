<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient extends Model
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
        return $this->hasMany(Appointment::class, 'patient', 'id');
    }
        
    
   
}
