<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = 'account';

    protected $fillable = [
        'account_number',
        'account_name',
        'account_balance',
    ];
}
