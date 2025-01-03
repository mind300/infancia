<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Nursery;

class AuthController extends Controller
{
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $nursery = Nursery::create($request->validated());
        return messageResponse();
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $token = auth()->attempt($request->safe()->only('email', 'password'));
        if (!$token) {
            return messageResponse('Email or password incorrect.', false, 422);
        }
        return authResponse($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return contentResponse(auth_user()->load('media'));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return messageResponse('Successfully logged out');
    }

    public function permissions()
    {
        $roles = auth_user()->roles; // Get all roles of the authenticated user
        if ($roles->isEmpty()) {
            return contentResponse(['message' => 'The user has no roles.'], 404);
        }
        $permissions = $roles->load('permissions')->pluck('permissions')->flatten()->pluck('name')->unique();
        return contentResponse(['role' => auth_user()->roles[0]->name, 'permissions' => $permissions]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return messageResponse(auth()->refresh());
    }
}
