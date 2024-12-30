<?php

namespace App\Models;

use App\Models\Account;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
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
    public function mypi()
    {
        return $this->belongsTo(Vendor::class, 'vendor');
    }
    public function mypii()
    {
        return $this->belongsTo(Account::class, 'payment_method');
    }
}
