<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_details extends Model
{
    use HasFactory;
    protected $fillable=[
        'purchase_id',
        'type',
        'product',
        'qty',
        'price',
       ];
}
