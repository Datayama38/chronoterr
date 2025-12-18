<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\RestController;
use App\Http\Methods\V1\RoleMethod;
use App\Http\Resources\V1\RoleResource;
use App\Http\Requests\V1\Role\CreateRequest;
use App\Http\Requests\V1\Role\UpdateRequest;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends RestController
{
    public function __construct(
        protected RoleMethod $roles
    ) {}

    public function index()
    {
        return RoleResource::collection(
            $this->roles->index()
        );
    }

    public function show(int $id)
    {
        $role = $this->roles->find($id);

        if (! $role) {
            return $this->error(
                'Role not found',
                Response::HTTP_NOT_FOUND
            );
        }

        return new RoleResource($role);
    }

    public function store(CreateRequest $request)
    {
        $role = $this->roles->store($request->validated());

        return $this->created(
            new RoleResource($role)
        );
    }

    public function update(UpdateRequest $request, int $id)
    {
        $role = $this->roles->update($request->validated(), $id);

        if (! $role) {
            return $this->error(
                'Role not found',
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->ok(
            new RoleResource($role)
        );
    }

    public function destroy(int $id)
    {
        if (! $this->roles->destroy($id)) {
            return $this->error(
                'Role not found',
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->noContent();
    }
}
