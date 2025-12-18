<?php
   
namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\V1\BaseController as BaseController;
use App\Http\Methods\V1\UserMethod;
use App\Http\Resources\V1\UserResource;
use App\Http\Requests\V1\User\CreateRequest;
use App\Http\Requests\V1\User\UpdateRequest;
   
class UserController extends BaseController
{
  protected $users;

  public function __construct(UserMethod $users)
  {
    $this->users = $users;
  }

  public function index()
  {
    return UserResource::collection($this->users->index());
  }

  public function show($id)
  {
    return new UserResource($this->users->find($id));
  }

  public function me()
  {
    return $this->users->me();
  }

  public function store(CreateRequest $request)
  {
    $this->users->store($request->all());
    return $this->handleResponse('success', 'User created');
  }

  public function update(UpdateRequest $request, $id)
  {
    $this->users->update($request->all(), $id);
    return $this->handleResponse('success', 'User modified');
  }

  public function destroy($id)
  {
    $this->users->destroy($id);
    return $this->handleResponse('success', 'User deleted');
  }
  
  public function search(Request $request)
  {
    return $this->users->search($request['text'],$request['auth']);
  }
}