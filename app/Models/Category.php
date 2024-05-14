<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
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

    public function business()
    {
        return $this->belongsToMany(Business::class);
    }
}
