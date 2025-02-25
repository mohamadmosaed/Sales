<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable=['tel','address','customer_name','sum_tax','','totalg','discount1','discount2','charge','type','cust_remark','bill_notes','paid','remain'];
}
