<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class People extends Model
{
    protected $fillable = [
        'name',
        'business_id',
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

    public function business(): HasOne
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withPivot('tag_id');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_people');
    }
}
