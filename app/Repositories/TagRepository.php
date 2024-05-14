<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(
        private Tag $tag
    ) {
        $this->tag = $tag;

        parent::__construct($this->tag);
    }

    public function get(): array
    {
        $tags = $this->tag->get();

        return $tags->toArray();
    }

    public function getById(int $id): array
    {
        $tag = $this->tag->findOrFail($id);

        return $tag->toArray();
    }

    public function create(array $data): array
    {
        $tag = $this->tag->create($data);

        return $tag->toArray();
    }

    public function update(array $data, int $id): array
    {
        $tag = $this->tag->findOrFail($id);
        $tag->update($data);

        return $tag->toArray();
    }
}
