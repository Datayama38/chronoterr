<?php
namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id'          => $this->id,
      'slug'        => $this->slug,
      'name'        => $this->name,
      'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
    ];
  }
}
