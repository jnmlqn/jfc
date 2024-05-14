<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(
        private Category $category
    ) {
        $this->category = $category;

        parent::__construct($this->category);
    }

    public function get(): array
    {
        $categories = $this->category->get();

        return $categories->toArray();
    }

    public function getById(int $id): array
    {
        $category = $this->category->findOrFail($id);

        return $category->toArray();
    }

    public function create(array $data): array
    {
        $category = $this->category->create($data);

        return $category->toArray();
    }

    public function update(array $data, int $id): array
    {
        $category = $this->category->findOrFail($id);
        $category->update($data);

        return $category->toArray();
    }
}
