<?php

namespace App\Repositories;

use App\Models\People;
use App\Models\PeopleTag;

class PeopleRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(
        private People $people,
        private PeopleTag $peopleTag
    ) {
        $this->people = $people;
        $this->peopleTag = $peopleTag;

        parent::__construct($this->people);
    }

    public function get(): array
    {
        $peoples = $this->people
            ->with('tags')
            ->with('business')
            ->get();

        return array_map(function ($people) {
            $people['tags'] = array_column($people['tags'], 'name');

            return $people;
        }, $peoples->toArray());
    }

    public function getById(int $id): array
    {
        $people = $this->people->with('tags', 'tasks')->findOrFail($id);

        return $people->toArray();
    }

    public function create(array $data): array
    {
        $people = $this->people->create($data);

        foreach ($data['tag_ids'] as $tag_id) {
            $people->tags()->attach($tag_id);
        }

        return $people->toArray();
    }

    public function update(array $data, int $id): array
    {
        $people = $this->people->findOrFail($id);
        $people->update($data);
        
        $this->peopleTag->where('people_id', $id)->delete();

        foreach ($data['tag_ids'] as $tag_id) {
            $people->tags()->attach($tag_id);
        }

        return $people->toArray();
    }
}
