<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(): JsonResponse
    {
        $categories = $this->categoryRepository->get();

        return response()->json([
            'message' => 'Categories fetched successfully',
            'data' => $categories,
        ], JsonResponse::HTTP_OK);
    }

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create category',
                'data' => [
                    'errors' => json_decode($validator->errors()->toJson(), true)
                ],
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category = $this->categoryRepository->create($validator->validated());

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category,
        ], JsonResponse::HTTP_CREATED);
    }

    public function read(int $id): JsonResponse
    {
        $category = $this->categoryRepository->getById($id);

        return response()->json([
            'message' => 'Category fetched successfully',
            'data' => $category,
        ], JsonResponse::HTTP_OK);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category',
                'data' => [
                    'errors' => json_decode($validator->errors()->toJson(), true)
                ],
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category = $this->categoryRepository->update($validator->validated(), $id);

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category,
        ], JsonResponse::HTTP_OK);
    }

    public function delete(int $id): JsonResponse
    {
        $category = $this->categoryRepository->delete($id);

        return response()->json([
            'message' => 'Category deleted successfully',
            'data' => $category,
        ], JsonResponse::HTTP_OK);
    }
}
