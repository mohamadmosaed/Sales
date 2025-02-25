<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_Brand extends Model
{
    protected $fillable=['sub_brand_ar','sub_brand_en','brand_id'];

    use HasFactory;
    public function subbrand(){
        return $this->belongsTo(Brand::class,'brand_id','id');
    }

}
