<?php

namespace App\Http\Methods\V1;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

class PermissionMethod
{
    public function __construct(
        protected Permission $model
    ) {}

    /**
     * Liste des permissions
     */
    public function index(): Collection
    {
        return $this->model->newQuery()->get();
    }

    /**
     * Récupère une permission par ID
     */
    public function find(int $id): ?Permission
    {
        return $this->model->newQuery()->find($id);
    }

    /**
     * Crée une permission
     */
    public function store(array $inputs): Permission
    {
        return $this->model->newQuery()->create($inputs);
    }

    /**
     * Met à jour une permission
     */
    public function update(array $inputs, int $id): ?Permission
    {
        $permission = $this->find($id);

        if (! $permission) {
            return null;
        }

        $permission->fill($inputs);
        $permission->save();

        return $permission;
    }

    /**
     * Supprime une permission
     */
    public function destroy(int $id): bool
    {
        $permission = $this->find($id);

        if (! $permission) {
            return false;
        }

        return (bool) $permission->delete();
    }
}
