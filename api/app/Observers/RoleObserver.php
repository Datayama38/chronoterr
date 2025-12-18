<?php
namespace App\Observers;

use App\Models\Role;

class RoleObserver
{
    public function created(Role $role): void
    {
        $this->flushPermissionsCache();
    }

    public function updated(Role $role): void
    {
        $this->flushPermissionsCache();
    }

    public function deleted(Role $role): void
    {
        $this->flushPermissionsCache();
    }

    private function flushPermissionsCache(): void
    {
        cache()->forget('roles_permissions');
    }
}
