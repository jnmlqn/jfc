<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeopleTag extends Model
{
    protected $table = 'people_tag';
    
    protected $fillable = [
        'people_id',
        'tag_id',
    ];

    public $timestamps = false;
}
