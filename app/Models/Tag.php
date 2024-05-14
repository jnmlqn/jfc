<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
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

    public function people()
    {
        return $this->belongsToMany(People::class);
    }
}
