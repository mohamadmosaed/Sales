<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name_of_company',
        'name_supplier',
        'mobile',
        'website',
        'supplier_vat_num',
        'opening_balance',
        'previous_balance',
        'period_to_pay',
        'date_of_pay',
        'total_paid',
        'total_remain',
        'supplier_balance',
        'address',
    ];
}
