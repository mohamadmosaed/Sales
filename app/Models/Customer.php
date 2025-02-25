<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'cust_name',
        'cust_type_id',
        'cust_vat_num',
        'cust_mobile',
        'cust_partnership_no',
        'cust_is_partnership_active',
        'cust_points',
        'cust_discount',
        'cust_balance',
        'card_number',
        'deposit_date',
        'cust_address',
        'cust_is_blacklist',
        'bill_notes',
    ];
    public function customerType(){
        return $this->belongsTo(CustomerType::class,'cust_type_id','id');
    }
}
