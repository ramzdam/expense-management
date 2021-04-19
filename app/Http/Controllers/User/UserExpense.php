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
     * Display a listing of the User Expense.
     *
     * @return Json
     */
    public function index($user_id)
    {
        $response = $this->getAll($this->model, $user_id);
        return response()->json(['success' => false, 'data' => $response]);
    }

    /**
     * Show the form for creating a new user expense.
     *
     * @param  string $user_id - User p_id
     * @return view
     */
    public function create($user_id)
    {
        $response = $this->expenseCategoryModel->get();
        return view('user.expense.form', ['expense_categories' => $response]);
    }

    /**
     * Store a newly created user expense in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $user_id - User Expense p_id
     * @return Json
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
     * Display the specified user expense.
     *
     * @param  string  $user_id - Auth user p_id
     * @param  string  $id - User Expense p_id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id, $id)
    {
    }

    /**
     * Show the form for editing the specified user expense.
     * 
     * @param  string  $user_id - Auth user p_id
     * @param  string  $id - User Expense p_id
     * @return view
     */
    public function edit($user_id, $id)
    {
        $expense = $this->getExpense($this->model, $id);
        $response = $this->expenseCategoryModel->get();

        return view('user.expense.edit-form', ['expense_categories' => $response, 'expense' => $expense]);
    }

    /**
     * Update the specified user expense in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $user_id - Auth user p_id
     * @param  string  $id - User Expense p_id
     * @return Json
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
     * Remove the specified user expense from storage.
     *
     * @param  string  $user_id - User p_id
     * @param  string  $id - User expense p_id
     * @return Json
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
