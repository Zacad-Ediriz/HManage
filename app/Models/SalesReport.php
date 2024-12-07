<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'patient_name', // Or customer name if needed
        'sub_total',
        'discount',
        'grand_total',
        'net_amount',
        'dues',
    ];
}


