<?php

namespace App\Repositories;

use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\BusinessTag;

class BusinessRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(
        private Business $business,
        private BusinessCategory $businessCategory,
        private BusinessTag $businessTag
    ) {
        $this->business = $business;
        $this->businessCategory = $businessCategory;
        $this->businessTag = $businessTag;

        parent::__construct($this->business);
    }

    public function get(): array
    {
        $businesses = $this->business->with('tags', 'categories')->get();

        return array_map(function ($business) {
            $business['tags'] = array_column($business['tags'], 'name');
            $business['categories'] = array_column($business['categories'], 'name');

            return $business;
        }, $businesses->toArray());
    }

    public function getById(int $id): array
    {
        $business = $this->business->with('tags', 'categories', 'tasks')->findOrFail($id);

        return $business->toArray();
    }

    public function create(array $data): array
    {
        $business = $this->business->create($data);

        foreach ($data['tag_ids'] as $tagId) {
            $business->tags()->attach($tagId);
        }

        foreach ($data['category_ids'] as $categoryId) {
            $business->categories()->attach($categoryId);
        }

        return $business->toArray();
    }

    public function update(array $data, int $id): array
    {
        $business = $this->business->findOrFail($id);
        $business->update($data);

        $this->businessTag->where('business_id', $id)->delete();
        $this->businessCategory->where('business_id', $id)->delete();

        foreach ($data['tag_ids'] as $tagId) {
            $business->tags()->attach($tagId);
        }

        foreach ($data['category_ids'] as $categoryId) {
            $business->categories()->attach($categoryId);
        }

        return $business->toArray();
    }
}
