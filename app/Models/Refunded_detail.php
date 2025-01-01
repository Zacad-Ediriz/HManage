<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refunded_detail extends Model
{
    use HasFactory;
    protected $fillable=[
     'refund_id',
     'type',
     'product',
     'qty',
     'price',
    ];
}
