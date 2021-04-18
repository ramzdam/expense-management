<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserExpenseRepository;
use App\Repositories\ExpenseCategoryRepository;
use App\Traits\UserExpenseTrait;


class UserExpense extends Controller
{
    use UserExpenseTrait;
    public $model;
    public $expenseCategoryModel;

    public function __construct(UserExpenseRepository $userExpenseRepository, ExpenseCategoryRepository $expenseCategoryRepository)
    {
        $this->model = $userExpenseRepository;
        $this->expenseCategoryModel = $expenseCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $response = $this->getAll($this->model, $user_id);
        return response()->json(['success' => false, 'data' => $response]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id)
    {
        $response = $this->expenseCategoryModel->get();
        return view('user.expense.form', ['expense_categories' => $response]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_id)
    {
        $response = $this->save($this->model, $request, $user_id);

        if ($response['status']) {
            $redirect = route("expense.home");
        }
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data'], 'redirect' => $redirect]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id, $id)
    {
        dd("Inside userexpense show", "user_id is " . $user_id, "expense_id is " . $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id, $id)
    {
        $expense = $this->getExpense($this->model, $id);
        $response = $this->expenseCategoryModel->get();

        return view('user.expense.edit-form', ['expense_categories' => $response, 'expense' => $expense]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id, $id)
    {
        $response = $this->updateRecord($this->model, $request, $user_id, $id);

        if ($response['status']) {
            $redirect = route("expense.home");
        }

        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data'], 'redirect' => $redirect]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $id)
    {
        $response = $this->deleteRecord($this->model, $user_id, $id);

        if ($response['status']) {
            $redirect = route("expense.home");
        }
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data'], 'redirect' => $redirect]);
    }
}
