<?php

namespace App\Http\Controllers;

use App\Repositories\TagRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TagsController extends Controller
{
    public function __construct(
        private TagRepository $tagRepository
    ) {
        $this->tagRepository = $tagRepository;
    }

    public function index(): JsonResponse
    {
        $tags = $this->tagRepository->get();

        return response()->json([
            'message' => 'Tags fetched successfully',
            'data' => $tags,
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
                'message' => 'Failed to create tag',
                'data' => [
                    'errors' => json_decode($validator->errors()->toJson(), true)
                ],
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $tag = $this->tagRepository->create($validator->validated());

        return response()->json([
            'message' => 'Tag created successfully',
            'data' => $tag,
        ], JsonResponse::HTTP_CREATED);
    }

    public function read(int $id): JsonResponse
    {
        $tag = $this->tagRepository->getById($id);

        return response()->json([
            'message' => 'Tag fetched successfully',
            'data' => $tag,
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
                'message' => 'Failed to update tag',
                'data' => [
                    'errors' => json_decode($validator->errors()->toJson(), true)
                ],
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $tag = $this->tagRepository->update($validator->validated(), $id);

        return response()->json([
            'message' => 'Tag updated successfully',
            'data' => $tag,
        ], JsonResponse::HTTP_OK);
    }

    public function delete(int $id): JsonResponse
    {
        $tag = $this->tagRepository->delete($id);

        return response()->json([
            'message' => 'Tag deleted successfully',
            'data' => $tag,
        ], JsonResponse::HTTP_OK);
    }
}
