<?php
   
namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\V1\BaseController as BaseController;
use App\Http\Methods\V1\RoleMethod;
use App\Http\Resources\V1\RoleResource;
use App\Http\Requests\V1\Role\CreateRequest;
use App\Http\Requests\V1\Role\UpdateRequest;
   
class RoleController extends BaseController
{
    protected $roles;

    public function __construct(RoleMethod $roles)
    {
      $this->roles = $roles;
    }

    public function index()
    {
      return RoleResource::collection($this->roles->index());
    }

    public function show($id)
    {
      return new RoleResource($this->roles->find($id));
    }

    public function store(CreateRequest $request)
    {
      $this->roles->store($request->all());
      return $this->handleResponse('success', 'Role created');
    }

    public function update(UpdateRequest $request, $id)
    {
      $this->roles->update($request->all(), $id);
      return $this->handleResponse('success', 'Role modified');
    }

    public function destroy($id)
    {
      $this->roles->destroy($id);
      return $this->handleResponse('success', 'Role deleted');
    }
}