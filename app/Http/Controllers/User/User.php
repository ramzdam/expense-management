<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use App\Traits\UserTrait;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->getAllUser($this->model);
        return view('user.index', ['users' => $response]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->roleModel->get();
        
        return view('user.form', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->getUser($this->model, $id);        
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data']]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = $this->roleModel->get();
        $response = $this->getUser($this->model, $id);
        
        return view('user.edit-form', ['roles' => $roles, 'user' => $response["data"], 'user_pid' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
