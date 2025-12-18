<?php
   
namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\RestController;
use App\Http\Methods\V1\PermissionMethod;
use App\Http\Resources\V1\PermissionResource;
use App\Http\Requests\V1\Permission\CreateRequest;
use App\Http\Requests\V1\Permission\UpdateRequest;

class PermissionController extends RestController
{
    protected $permissions;

    public function __construct(PermissionMethod $permissions)
    {
      $this->permissions = $permissions;
    }

    public function index()
    {
      return PermissionResource::collection($this->permissions->index());
    }

    public function show($id)
    {
      return new PermissionResource($this->permissions->find($id));
    }

    public function store(CreateRequest $request)
    {
      $this->permissions->store($request->all());
      return $this->handleResponse('success', 'Permission created');
    }

    public function update(UpdateRequest $request, $id)
    {
      $this->permissions->update($request->all(), $id);
      return $this->handleResponse('success', 'Permission modified');
    }

    public function destroy($id)
    {
      $this->permissions->destroy($id);
      return $this->handleResponse('success', 'Permission deleted');
    }
}