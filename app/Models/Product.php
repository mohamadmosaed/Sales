<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function categoryproduct() {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function categorysub() {
        return $this->belongsTo(Sub_Category::class,'sub_category_id','id');
    }

    public function brand() {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
    public function brandsub() {
        return $this->belongsTo(Sub_Brand::class,'sub_brand_id','id');
    }
}
