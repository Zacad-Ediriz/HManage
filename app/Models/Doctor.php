<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $table = 'doctor';

    protected $fillable = [
      
        'Name',
        
        'Sex',
        'Address',
       'Doctore_phone',
        

    ];
    public function schedules()
    {
        return $this->hasMany(ScheduleDoctor::class);
    }
    

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
   
}
