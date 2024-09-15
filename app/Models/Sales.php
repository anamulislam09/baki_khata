<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'auth_id',
        'user_id',
        'invoice_id',
        'sales_amount',
        'collection',
        'due',
        'date',
        'month',
        'year',
    ];
}
