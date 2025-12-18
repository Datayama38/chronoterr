<?php

namespace App\Http\Methods\V1;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserMethod
{
    public function __construct(
        protected User $model
    ) {}
    /**
     * Liste des utilisateurs
     */
    public function index(): Collection
    {
        return $this->model
            ->newQuery()
            ->with(['role', 'role.permissions'])
            ->get();
    }
    /**
     * Récupère un utilisateur par ID
     */
    public function find(int $id): ?User
    {
        return $this->model
            ->newQuery()
            ->with(['role', 'role.permissions'])
            ->find($id);
    }
    /**
     * Utilisateur courant
     */
    public function me(): ?User
    {
        return Auth::user()?->load(['role', 'role.permissions']);
    }
    /**
     * Crée un utilisateur
     */
    public function store(array $inputs): User
    {
        $user = $this->model->newQuery()->create([
            ...$inputs,
            'password' => Hash::make($inputs['password']),
            'role_id'  => $inputs['role'] ?? null,
        ]);

        return $user->load(['role', 'role.permissions']);
    }
    /**
     * Met à jour un utilisateur
     */
    public function update(array $inputs, int $id): ?User
    {
        $user = $this->find($id);

        if (! $user) {
            return null;
        }

        if (isset($inputs['role'])) {
            $inputs['role_id'] = $inputs['role'];
        }

        if (isset($inputs['password'])) {
            $inputs['password'] = Hash::make($inputs['password']);
        } else {
            unset($inputs['password']);
        }

        $user->fill($inputs);
        $user->save();

        return $user->load(['role', 'role.permissions']);
    }
    /**
     * Supprime un utilisateur
     */
    public function destroy(int $id): bool
    {
        $user = $this->find($id);

        if (! $user) {
            return false;
        }

        return (bool) $user->delete();
    }
    /**
     * Recherche utilisateurs
     */
    public function search(
        string $text,
        bool|string|null $auth = null
    ): LengthAwarePaginator {
        $query = $this->model
            ->newQuery()
            ->select(['id', 'firstname', 'name'])
            ->where(function ($q) use ($text) {
                $q->where('name', 'ILIKE', "%{$text}%")
                  ->orWhere('firstname', 'ILIKE', "%{$text}%");
            });
        return $query
            ->orderBy('id')
            ->paginate(100);
    }
}
