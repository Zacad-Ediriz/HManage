<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment_formm extends Model
{
    use HasFactory;
    protected $table = 'payment_formm';
    protected $fillable = [
        'patient',
        'amount',
        'account_number'
    ];
}
