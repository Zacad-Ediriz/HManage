<?php

namespace App\Models;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay_bills extends Model
{
    use HasFactory;
    protected $table = 'pay_bills';
    protected $fillable = [ 
        'vendor',
        'amount',
        'amount_paid',
        'balance',
        'paybills_method_id',
    ];
    public function mypi()
    {
        return $this->belongsTo(Vendor::class, 'vendor');
    }
}
