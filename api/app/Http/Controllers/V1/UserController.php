<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\RestController;
use App\Http\Methods\V1\UserMethod;
use App\Http\Resources\V1\UserResource;
use App\Http\Requests\V1\User\CreateRequest;
use App\Http\Requests\V1\User\UpdateRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends RestController
{
    public function __construct(
        protected UserMethod $users
    ) {}

    public function index()
    {
        return UserResource::collection(
            $this->users->index()
        );
    }

    public function show(int $id)
    {
        $user = $this->users->find($id);
        if (! $user) {
            return $this->error(
                'User not found',
                Response::HTTP_NOT_FOUND
            );
        }
        return new UserResource($user);
    }
    /**
     * Utilisateur courant (authentifié)
     */
    public function me()
    {
        $user = $this->users->me();
        if (! $user) {
            return $this->error(
                'Unauthenticated',
                Response::HTTP_UNAUTHORIZED
            );
        }
        return new UserResource($user);
    }

    public function store(CreateRequest $request)
    {
        $user = $this->users->store(
            $request->validated()
        );
        return $this->created(
            new UserResource($user)
        );
    }

    public function update(UpdateRequest $request, int $id)
    {
        $user = $this->users->update(
            $request->validated(),
            $id
        );
        if (! $user) {
            return $this->error(
                'User not found',
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->ok(
            new UserResource($user)
        );
    }

    public function destroy(int $id)
    {
        if (! $this->users->destroy($id)) {
            return $this->error(
                'User not found',
                Response::HTTP_NOT_FOUND
            );
        }
        return $this->noContent();
    }
    /**
     * Recherche utilisateurs
     */
    public function search(Request $request)
    {
        $request->validate([
            'text' => ['required', 'string'],
            'auth' => ['nullable', 'boolean'],
        ]);
        $users = $this->users->search(
            $request->string('text'),
            $request->boolean('auth')
        );
        return UserResource::collection($users);
    }
}
