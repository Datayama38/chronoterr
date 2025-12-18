<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'firstname'    => $this->firstname,
            'name'         => $this->name,
            'organization' => $this->organization,
            'email'        => $this->email,
            'role'         => new RoleResource($this->whenLoaded('role')),
            'permissions'  => PermissionResource::collection($this->whenLoaded('permissions')),
        ];
    }
}
