<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Nursery;
use App\Notifications\NurseryRegisterNotification;

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
        $nursery->notify(new NurseryRegisterNotification());
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
        $roles = auth_user()->roles;
        if ($roles->isEmpty()) {
            return messageResponse('The user has no roles.', false, 404);
        }
        $permissions = auth_user()->permissions;
        return contentResponse(['role' => auth_user()->roles[0]->name, 'permissions' => $permissions->pluck('name')]);
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
