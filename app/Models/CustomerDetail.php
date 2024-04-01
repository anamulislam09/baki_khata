<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'phone',
        'address',
        'nid_no',
        'image',
    ];
}
