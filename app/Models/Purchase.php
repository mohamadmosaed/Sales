<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;


    protected $fillable = [
        'date_bill_purchase',
        'supplier_id',
        'type_payment',
        'date_of_pay',
        'bill_number'
    ];

    public function purchaseDetails(){
        return $this->hasMany(PurchaseDetails::class,'purchase_id','id');
    }
    public function supplierMan(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }
    public function purchase(){
        return $this->belongsTo(Purchase::class,'purchase_id','id');
    }
}
