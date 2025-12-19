<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\V1\UserResource;
use App\Http\Controllers\RestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends RestController
{
    /**
     * Login — retourne un token Sanctum
     */
    public function login(LoginRequest $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return $this->error(
                'Invalid credentials',
                Response::HTTP_UNAUTHORIZED
            );
        }

        $user = $request->user();

        $token = $user->createToken('chronoterr_api')->plainTextToken;

        return $this->created([
            'token' => $token,
            'user'  => new UserResource($user),
        ]);
    }

    /**
     * Logout — invalide tous les tokens
     */
    public function logout(Request $request)
    {
        $request->user()?->tokens()->delete();

        return $this->noContent();
    }

    /**
     * Register — crée un utilisateur + token
     */
    public function register(RegisterRequest $request)
    {
        $user = $request->validated();

        $user = \App\Models\User::create([
            ...$user,
            'password' => bcrypt($user['password']),
        ]);

        $token = $user->createToken('api')->plainTextToken;

        return $this->created([
            'token' => $token,
            'user'  => new UserResource($user),
        ]);
    }

    /**
     * Me — utilisateur courant
     */
    public function me(Request $request)
    {
        return $this->ok(
            new UserResource($request->user())
        );
    }
}
