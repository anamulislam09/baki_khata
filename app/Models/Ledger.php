<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'auth_id',
        'expense',
        'income',
        'balance',
    ];
}
