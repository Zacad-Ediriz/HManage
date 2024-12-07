<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDoctor extends Model
{
    use HasFactory;
    protected $table = 'schedule_doctors';

    protected $fillable = [
        'schedule_name',
        'doctor_id',
        'day',
        'start_time',
        'end_time',
        'fees',
        'number_of_visits',
    ];

    /**
     * Define a relationship with the User model (for doctors).
     */
    public function Doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
