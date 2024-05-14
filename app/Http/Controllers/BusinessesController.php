<?php

namespace App\Http\Controllers;

use App\Repositories\BusinessRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\TagRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BusinessesController extends Controller
{
    public function __construct(
        private BusinessRepository $businessRepository,
        private CategoryRepository $categoryRepository,
        private TagRepository $tagRepository
    ) {
        $this->businessRepository = $businessRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    public function index(): JsonResponse
    {
        $businesses = $this->businessRepository->get();

        return response()->json([
            'message' => 'Businesses fetched successfully',
            'data' => $businesses,
        ], JsonResponse::HTTP_OK);
    }

    public function create(Request $request): JsonResponse
    {
        $tagIds = array_column($this->tagRepository->get(), 'id');
        $categoryIds = array_column($this->categoryRepository->get(), 'id');

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255'
            ],
            'tag_ids' => [
                'array',
                Rule::in($tagIds)
            ],
            'category_ids' => [
                'array',
                Rule::in($categoryIds)
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create business',
                'data' => [
                    'errors' => json_decode($validator->errors()->toJson(), true)
                ],
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $business = $this->businessRepository->create($validator->validated());

        return response()->json([
            'message' => 'Business created successfully',
            'data' => $business,
        ], JsonResponse::HTTP_CREATED);
    }

    public function read(int $id): JsonResponse
    {
        $business = $this->businessRepository->getById($id);

        return response()->json([
            'message' => 'Business fetched successfully',
            'data' => $business,
        ], JsonResponse::HTTP_OK);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $tagIds = array_column($this->tagRepository->get(), 'id');
        $categoryIds = array_column($this->categoryRepository->get(), 'id');

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255'
            ],
            'tag_ids' => [
                'array',
                Rule::in($tagIds)
            ],
            'category_ids' => [
                'array',
                Rule::in($categoryIds)
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update business',
                'data' => [
                    'errors' => json_decode($validator->errors()->toJson(), true)
                ],
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $business = $this->businessRepository->update($validator->validated(), $id);

        return response()->json([
            'message' => 'Business updated successfully',
            'data' => $business,
        ], JsonResponse::HTTP_OK);
    }

    public function delete(int $id): JsonResponse
    {
        $business = $this->businessRepository->delete($id);

        return response()->json([
            'message' => 'Business deleted successfully',
            'data' => $business,
        ], JsonResponse::HTTP_OK);
    }
}
