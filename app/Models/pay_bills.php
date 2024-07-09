<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pay_bills extends Model
{
    use HasFactory;
    protected $table = 'pay_bills';
    protected $fillable = [
        'purchase',
        'vendor_id',
        'balance',
        'amount',
        'amount_paid',
        'payment_method'
    ];
}
