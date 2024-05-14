<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessTag extends Model
{
    protected $table = 'business_tag';

    protected $fillable = [
        'business_id',
        'tag_id',
    ];

    public $timestamps = false;
}
