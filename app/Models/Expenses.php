<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account; // Import the Account model

class Expenses extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'expenses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'category',
        'name',
        'description',
        'amount',
        'account'
    ];

    /**
     * Get the account associated with the expense.
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'AccountNumber', 'AccountNumber');
    }
}
