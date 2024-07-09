<?php

namespace App\Models;

use App\Models\Account;
use App\Models\patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoice extends Model
{
    use HasFactory;
    protected $fillable = [

        'patient',
        'total',
        'discount',
        'net_total',
        'amount_paid',
        'balance',
        'payment_method',
        'appointment_status',
        'payment_status',
    ];
    public function mypi()
    {
        return $this->belongsTo(patient::class, 'patient');
    }
    public function myacount()
    {
        return $this->belongsTo(Account::class, 'payment_method');
    }
}
