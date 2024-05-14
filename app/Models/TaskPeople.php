<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskPeople extends Model
{
    protected $table = 'task_people';

    protected $fillable = [
        'task_id',
        'people_id',
    ];

    public $timestamps = false;
}
