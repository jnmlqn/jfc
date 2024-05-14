<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
{
    protected $table = 'business_category';

    protected $fillable = [
        'business_id',
        'category_id',
    ];

    public $timestamps = false;
}
