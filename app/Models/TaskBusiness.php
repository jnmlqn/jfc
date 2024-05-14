<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskBusiness extends Model
{
    protected $table = 'task_business';
    
    protected $fillable = [
        'task_id',
        'business_id',
    ];

    public $timestamps = false;
}
