<?php

namespace App\Http\Controllers;

use App\Repositories\BusinessRepository;
use App\Repositories\PeopleRepository;
use App\Repositories\TaskRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TasksController extends Controller
{
    public function __construct(
        private BusinessRepository $businessRepository,
        private PeopleRepository $peopleRepository,
        private TaskRepository $taskRepository
    ) {
        $this->businessRepository = $businessRepository;
        $this->peopleRepository = $peopleRepository;
        $this->taskRepository = $taskRepository;
    }

    public function index(): JsonResponse
    {
        $tasks = $this->taskRepository->get();

        return response()->json([
            'message' => 'Tasks fetched successfully',
            'data' => $tasks,
        ], JsonResponse::HTTP_OK);
    }

    public function create(Request $request): JsonResponse
    {
        $businessIds = array_column($this->businessRepository->get(), 'id');
        $peopleIds = array_column($this->peopleRepository->get(), 'id');

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255'
            ],
            'description' => [
                'required'
            ],
            'business_ids' => [
                'array',
                Rule::in($businessIds)
            ],
            'people_ids' => [
                'array',
                Rule::in($peopleIds)
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create task',
                'data' => [
                    'errors' => json_decode($validator->errors()->toJson(), true)
                ],
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $task = $this->taskRepository->create($validator->validated());

        return response()->json([
            'message' => 'Task created successfully',
            'data' => $task,
        ], JsonResponse::HTTP_CREATED);
    }

    public function read(int $id): JsonResponse
    {
        $task = $this->taskRepository->getById($id);

        return response()->json([
            'message' => 'Task fetched successfully',
            'data' => $task,
        ], JsonResponse::HTTP_OK);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $businessIds = array_column($this->businessRepository->get(), 'id');
        $peopleIds = array_column($this->peopleRepository->get(), 'id');

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255'
            ],
            'description' => [
                'required'
            ],
            'business_ids' => [
                'array',
                Rule::in($businessIds)
            ],
            'people_ids' => [
                'array',
                Rule::in($peopleIds)
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update task',
                'data' => [
                    'errors' => json_decode($validator->errors()->toJson(), true)
                ],
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $task = $this->taskRepository->update($validator->validated(), $id);

        return response()->json([
            'message' => 'Task updated successfully',
            'data' => $task,
        ], JsonResponse::HTTP_OK);
    }

    public function delete(int $id): JsonResponse
    {
        $task = $this->taskRepository->delete($id);

        return response()->json([
            'message' => 'Task deleted successfully',
            'data' => $task,
        ], JsonResponse::HTTP_OK);
    }
}
