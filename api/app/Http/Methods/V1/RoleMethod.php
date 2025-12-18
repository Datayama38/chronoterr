<?php

namespace App\Http\Methods\V1;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleMethod
{
    public function __construct(
        protected Role $model
    ) {}

    /**
     * Liste des rôles avec permissions
     */
    public function index(): Collection
    {
        return $this->model
            ->newQuery()
            ->with('permissions')
            ->get();
    }
    /**
     * Récupère un rôle par ID
     */
    public function find(int $id): ?Role
    {
        return $this->model
            ->newQuery()
            ->with('permissions')
            ->find($id);
    }
    /**
     * Crée un rôle
     */
    public function store(array $inputs): Role
    {
        $role = $this->model
            ->newQuery()
            ->create($inputs);
        if (! empty($inputs['permissions'])) {
            $role->permissions()->sync($inputs['permissions']);
        }
        return $role->load('permissions');
    }
    /**
     * Met à jour un rôle
     */
    public function update(array $inputs, int $id): ?Role
    {
        $role = $this->find($id);
        if (! $role) {
            return null;
        }
        $role->fill($inputs);
        $role->save();
        if (array_key_exists('permissions', $inputs)) {
            $role->permissions()->sync($inputs['permissions'] ?? []);
        }
        return $role->load('permissions');
    }
    /**
     * Supprime un rôle
     */
    public function destroy(int $id): bool
    {
        $role = $this->find($id);
        if (! $role) {
            return false;
        }
        return (bool) $role->delete();
    }
}
