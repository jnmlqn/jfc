<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    public function __construct (
        private Model $model
    ) {
        $this->model = $model;
    }

    public function delete(int $id): bool
    {
        $this->model->where('id', $id)->delete();

        return true;
    }
}
