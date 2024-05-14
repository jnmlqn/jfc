<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
    ];

    public static function booted(): void
    {
        static::creating(function ($model) {
            $model->created_by = request()->user()->id;
            $model->updated_by = request()->user()->id;
        });
    }

    public function peoples(): BelongsToMany
    {
        return $this->belongsToMany(People::class, 'task_people')->withPivot('people_id');
    }

    public function businesses(): BelongsToMany
    {
        return $this->belongsToMany(Business::class, 'task_business')->withPivot('business_id');
    }
}
