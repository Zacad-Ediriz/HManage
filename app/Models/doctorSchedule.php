<?php

namespace App\Models;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class doctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor',
        'days',
        'start_time',
        'end_time',
    ];
    public function mydoct()
    {
        return $this->belongsTo(Doctor::class, 'doctor');
    }
}
