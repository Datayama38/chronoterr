<?php

namespace App\Observers;

use App\Models\Permission;

class PermissionObserver
{
    public function created(Permission $permission): void
    {
        $this->flushPermissionsCache();
    }

    public function updated(Permission $permission): void
    {
        $this->flushPermissionsCache();
    }

    public function deleted(Permission $permission): void
    {
        $this->flushPermissionsCache();
    }

    private function flushPermissionsCache(): void
    {
        cache()->forget('roles_permissions');
    }
}
