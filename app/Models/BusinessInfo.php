<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_id',
        'name',
        'landmark',
        'country',
        'city',
        'state',
        'country_en',
        'city_en',
        'state_en',
        'name_en',
        'zip_code_en',
        'mobile',
        'alternate_number',
        'email',
        'website'
    ];
}
