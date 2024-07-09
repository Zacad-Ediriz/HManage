<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emplooyee extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'name',
        'sex',
        'phone',
        'address',
    ];
}
