<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_Category extends Model
{
    use HasFactory;
    protected $fillable=['sub_category_ar','sub_category_en','category_id'];

    public function subcategory(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

}
