<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\TaskPeople;
use App\Models\TaskBusiness;

class TaskRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(
        private Task $task,
        private TaskBusiness $taskBusiness,
        private TaskPeople $taskPeople
    ) {
        $this->task = $task;
        $this->taskBusiness = $taskBusiness;
        $this->taskPeople = $taskPeople;

        parent::__construct($this->task);
    }

    public function get(): array
    {
        $tasks = $this->task
            ->with('peoples', 'businesses')
            ->get();

        return array_map(function ($task) {
            $task['peoples'] = array_column($task['peoples'], 'name');
            $task['businesses'] = array_column($task['businesses'], 'name');

            return $task;
        }, $tasks->toArray());
    }

    public function getById(int $id): array
    {
        $task = $this->task
            ->with('peoples', 'businesses')
            ->findOrFail($id);

        return $task->toArray();
    }

    public function create(array $data): array
    {
        $task = $this->task->create($data);

        foreach ($data['business_ids'] as $business_id) {
            $task->businesses()->attach($business_id);
        }

        foreach ($data['people_ids'] as $people_id) {
            $task->peoples()->attach($people_id);
        }

        return $task->toArray();
    }

    public function update(array $data, int $id): array
    {
        $task = $this->task->findOrFail($id);
        $task->update($data);

        $this->taskPeople->where('task_id', $id)->delete();
        $this->taskBusiness->where('task_id', $id)->delete();

        foreach ($data['business_ids'] as $business_id) {
            $task->businesses()->attach($business_id);
        }

        foreach ($data['people_ids'] as $people_id) {
            $task->peoples()->attach($people_id);
        }

        return $task->toArray();
    }
}
