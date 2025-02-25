<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'supplier_id',
        'product_ar',
        'product_en',
        'purchase_price',
        'discount',
        'quantity',
        'product_date',
        'tax',
        'expired_date',
        'paid',
        'remainder'
    ];

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }
    public function supplierMan(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }
    public function purchaseMan(){
        return $this->belongsTo(Purchase::class,'purchase_id','id');
    }
}
