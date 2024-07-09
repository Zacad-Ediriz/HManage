<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchase extends Model
{
    use HasFactory;
    protected $fillable = [

        'vendor',
        'total',
        'discount',
        'net_total',
        'amount_paid',
        'balance',
        'payment_method',
        'payment_status',
    ];
}
