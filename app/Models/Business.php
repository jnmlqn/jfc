<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Business extends Model
{
    protected $fillable = [
        'name',
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

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withPivot('tag_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withPivot('category_id');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_business');
    }
}
