<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use App\Traits\UserTrait;
use Auth;

class User extends Controller
{
    use UserTrait;
    public $model;
    public $roleModel;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->model = $userRepository;
        $this->roleModel = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return view
     */
    public function index()
    {
        $response = $this->getAllUser($this->model);
        return view('user.index', ['users' => $response]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return view
     */
    public function create()
    {
        $roles = $this->roleModel->get();
        
        return view('user.form', ['roles' => $roles]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function store(Request $request)
    {
        $response = $this->save($this->model, $request);

        if ($response['status']) {
            $redirect = route("user.home");
        }
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data'], 'redirect' => $redirect]);
    }

    /**
     * Display the specified user.
     *
     * @param  string  $id
     * @return Json
     */
    public function show($id)
    {
        $response = $this->getUser($this->model, $id);        
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data']]);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  string  $id - User p_id
     * @return view
     */
    public function edit($id)
    {
        $roles = $this->roleModel->get();
        $response = $this->getUser($this->model, $id);
        
        return view('user.edit-form', ['roles' => $roles, 'user' => $response["data"], 'user_pid' => $id]);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  string  $id - User p_id
     * @return view
     */
    public function userEdit($id)
    {
        $roles = $this->roleModel->get();
        $response = $this->getUser($this->model, $id);
        
        return view('user.user-edit-form', ['roles' => $roles, 'user' => $response["data"], 'user_pid' => $id]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id - User p_id
     * @return Json
     */
    public function update(Request $request, $id)
    {
        $response = $this->updateRecord($this->model, $request, $id);
        
        if ($response['status']) {
            $redirect = route("user.home");
        }
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data'], 'redirect' => $redirect]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id - User p_id
     * @return Json
     */
    public function userUpdate(Request $request, $id)
    {
        $response = $this->updateRecord($this->model, $request, $id);
        
        if ($response['status']) {
            $redirect = route('user.useredit.form', ['id'=> Auth::user()->p_id]);
        }
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data'], 'redirect' => $redirect]);
    }
    /**
     * Remove the specified user from storage.
     *
     * @param  string  $id - User p_id
     * @return Json
     */
    public function destroy($id)
    {
        $response = $this->deleteRecord($this->model, $id);
        
        if ($response['status']) {
            $redirect = route("user.home");
        }
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data'], 'redirect' => $redirect]);
    }

}
