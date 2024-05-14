<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function get(): array;
    public function getById(int $id): array;
    public function create(array $data): array;
    public function update(array $data, int $id): array;
    public function delete(int $id): bool;
}
