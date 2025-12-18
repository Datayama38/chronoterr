<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\RestController;
use App\Http\Methods\V1\PermissionMethod;
use App\Http\Requests\V1\Permission\CreateRequest;
use App\Http\Requests\V1\Permission\UpdateRequest;
use App\Http\Resources\V1\PermissionResource;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends RestController
{
    public function __construct(
        protected PermissionMethod $permissions
    ) {}

    /**
     * GET /permissions
     */
    public function index()
    {
        return PermissionResource::collection(
            $this->permissions->index()
        );
    }

    /**
     * GET /permissions/{id}
     */
    public function show(int $id)
    {
        $permission = $this->permissions->find($id);

        if (! $permission) {
            return $this->error(
                'Permission not found',
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->ok(
            new PermissionResource($permission)
        );
    }

    /**
     * POST /permissions
     */
    public function store(CreateRequest $request)
    {
        $permission = $this->permissions->store(
            $request->validated()
        );

        return $this->created(
            new PermissionResource($permission)
        );
    }

    /**
     * PUT /permissions/{id}
     */
    public function update(UpdateRequest $request, int $id)
    {
        $permission = $this->permissions->update(
            $request->validated(),
            $id
        );

        if (! $permission) {
            return $this->error(
                'Permission not found',
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->ok(
            new PermissionResource($permission)
        );
    }

    /**
     * DELETE /permissions/{id}
     */
    public function destroy(int $id)
    {
        $deleted = $this->permissions->destroy($id);

        if (! $deleted) {
            return $this->error(
                'Permission not found',
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->noContent();
    }
}
