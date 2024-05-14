<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct(
        private UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'data' => [
                    'errors' => json_decode($validator->errors()->toJson(), true)
                ],
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $token = $this->userRepository->createLoginToken(
                $validator->validated()['email'],
                $validator->validated()['password']
            );

            $data = [
                'success' => true,
                'message' => 'Successfully logged in',
                'data' => [
                    'token' => $token,
                ],
            ];

            $code = JsonResponse::HTTP_OK;
        } catch (ModelNotFoundException $e) {
            $data = [
                'success' => false,
                'message' => 'Account not found',
            ];

            $code = JsonResponse::HTTP_UNAUTHORIZED;
        } catch (Exception $e) {
            $data = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
            
            $code = JsonResponse::HTTP_UNAUTHORIZED;
        }

        return response()->json($data, $code);
    }
}
