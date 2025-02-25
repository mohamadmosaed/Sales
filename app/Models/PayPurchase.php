<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayPurchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_id',
        'bill_number',
        'payment-method',
        'remaining-balance',
        'paid-amount',
    ];
}
