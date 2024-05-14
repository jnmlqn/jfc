<?php

namespace App\Http\Controllers;

use App\Repositories\PeopleRepository;
use App\Repositories\TagRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PeopleController extends Controller
{
    public function __construct(
        private PeopleRepository $peopleRepository,
        private TagRepository $tagRepository
    ) {
        $this->peopleRepository = $peopleRepository;
        $this->tagRepository = $tagRepository;
    }

    public function index(): JsonResponse
    {
        $peoples = $this->peopleRepository->get();

        return response()->json([
            'message' => 'Peoples fetched successfully',
            'data' => $peoples,
        ], JsonResponse::HTTP_OK);
    }

    public function create(Request $request): JsonResponse
    {
        $tagIds = array_column($this->tagRepository->get(), 'id');

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255'
            ],
            'business_id' => [
                'required',
                'exists:businesses,id'
            ],
            'tag_ids' => [
                'array',
                Rule::in($tagIds)
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create people',
                'data' => [
                    'errors' => json_decode($validator->errors()->toJson(), true)
                ],
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $people = $this->peopleRepository->create($validator->validated());

        return response()->json([
            'message' => 'People created successfully',
            'data' => $people,
        ], JsonResponse::HTTP_CREATED);
    }

    public function read(int $id): JsonResponse
    {
        $people = $this->peopleRepository->getById($id);

        return response()->json([
            'message' => 'People fetched successfully',
            'data' => $people,
        ], JsonResponse::HTTP_OK);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $tagIds = array_column($this->tagRepository->get(), 'id');

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255'
            ],
            'business_id' => [
                'required',
                'exists:businesses,id'
            ],
            'tag_ids' => [
                'array',
                Rule::in($tagIds)
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update people',
                'data' => [
                    'errors' => json_decode($validator->errors()->toJson(), true)
                ],
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $people = $this->peopleRepository->update($validator->validated(), $id);

        return response()->json([
            'message' => 'People updated successfully',
            'data' => $people,
        ], JsonResponse::HTTP_OK);
    }

    public function delete(int $id): JsonResponse
    {
        $people = $this->peopleRepository->delete($id);

        return response()->json([
            'message' => 'People deleted successfully',
            'data' => $people,
        ], JsonResponse::HTTP_OK);
    }
}
