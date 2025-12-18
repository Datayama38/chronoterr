<?php 
namespace App\Http\Methods\V1;

use App\Http\Methods\BaseMethod;
use App\Models\Permission;

class PermissionMethod extends BaseMethod
{
	public function __construct(Permission $permission)
	{
		$this->model = $permission;
	}

	public function index()
	{
		return $this->model->get();
	}

	public function find($id)
	{
		return $this->model->findOrFail($id);
	}

	public function store($inputs)
	{
	    $permission = new $this->model;
	    $permission->fill($inputs);
	    $permission->save();
	}

	public function update($inputs, $id)
	{
		$permission = $this->model->find($id);
		$permission->fill($inputs);
		$permission->save();
	}
    
	public function destroy($id)
	{
		$permission = $this->model->find($id);
		$permission->delete();
	}
}
