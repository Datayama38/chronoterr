<?php 
namespace App\Http\Methods\V1;

use App\Http\Methods\BaseMethod;
use App\Models\Role;

class RoleMethod extends BaseMethod
{
	public function __construct(Role $role)
	{
		$this->model = $role;
	}

	public function index()
	{
		return $this->model->with('permissions')->get();
	}

	public function find($id)
	{
		return $this->model->with('permissions')->findOrFail($id);
	}

	public function store($inputs)
	{
		$role = new $this->model;
		$role->fill($inputs);
		$role->save();
		if(isset($inputs['permissions'])){
			$role->permissions()->sync($inputs['permissions']);
		}
	}

	public function update($inputs, $id)
	{
		$role = $this->model->find($id);
		$role->fill($inputs);
		$role->save();
		if(isset($inputs['permissions'])){
			$role->permissions()->sync($inputs['permissions']);
		}
	}
    
	public function destroy($id)
	{
		$role = $this->model->find($id);
		$role->delete();
	}
}
