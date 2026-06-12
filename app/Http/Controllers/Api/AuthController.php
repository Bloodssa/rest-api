<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\TokenResource;
use App\Services\UserServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(private readonly UserServices $userService) {}

    /**
     * response in not auth request
     */
    public function index(): JsonResponse
    {
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }

    /**
     * Registers a user
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->register($request->validated());

        return response()->json([
            "success" => (bool) true,
            "message" => "User Registered Successfully",
            "data" => [
                "name" => $user->name,
                "email" => $user->email,
            ]
        ], 201);
    }

    /**
     * auth the user and return jwt access token
     */
    public function login(LoginRequest $request): TokenResource
    {
        $request->ensureIsNotRateLimmited();

        try {
            $token = $this->userService->attemptLogin($request->validated());

            RateLimiter::clear($request->throttleKey());
            return new TokenResource($token);
        }catch(ValidationException $e) {
            RateLimiter::hit($request->throttleKey(), 60);

            Log::warning("Failed login attempt detected. Email: {$request->input('email')} | IP: {$request->ip()}");

            throw $e;
        }
    }

    /**
     * get auth user profile
     */
    public function profile(): JsonResponse
    {
        return response()->json(auth('api')->user());
    }

    /**
     * log out the user and invalidate the token 
     */
    public function logout(): JsonResponse
    {
        /** @var \Illuminate\Contracts\Auth\StatefulGuard $auth*/
        $auth = auth('api');
        $auth->logout();

        return response()->json([
            "message" => 'Successfully logged out'
        ]);
    }

    public function refresh(): TokenResource
    {
        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $auth */
        $auth = auth('api');

        return new TokenResource($auth->refresh());
    }
}