<?php 
namespace App\Http\Methods\V1;

use App\Http\Methods\BaseMethod;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserMethod extends BaseMethod
{
	public function __construct(User $user)
	{
		$this->model = $user;
	}

	public function index()
	{
		return $this->model->with(['role','role.permissions'])->get();
	}

	public function find($id)
	{
		return $this->model->with(['role','role.permissions'])->findOrFail($id);
	}

	public function store($inputs)
	{
	    $user = new $this->model;
	    $user->fill($inputs);
			if(isset($inputs['role'])){
				$user->role_id = $inputs['role'];
			}
			$user->password = bcrypt($user->password);
	    $user->save();
	}

	public function update($inputs, $id)
	{
		$user = $this->model->find($id);
		$user->fill($inputs);
		if(isset($inputs['role'])){
			$user->role_id = $inputs['role'];
		}
		if(isset($inputs['password'])){
			$user->password = bcrypt($inputs['password']);
		}
		$user->save();
	}
    
	public function destroy($id)
	{
		$user = $this->model->find($id);
		$user->delete();
	}

	public function search($text, $auth)
	{
		$search = $this->model
			->select(array('id','firstname','name'))
			->where(function ($query) use ($text) {
				$query->where('name','ILIKE','%'.$text.'%')
					->orWhere('firstname','ILIKE','%'.$text.'%');
			});
		switch ($auth) {
			case 'all':
				break;
			case 'dep':
				$search->where('departement', Auth::user()->departement);
				break;
			default:
				break;
		}
		return $search->orderBy('id','asc')
			->paginate(100);
	}
}
