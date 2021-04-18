<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\UserExpenseTrait;
use App\Repositories\UserExpenseRepository;
use Auth;

class Expense extends Controller
{
    use UserExpenseTrait;
    public $model;

    public function __construct(UserExpenseRepository $userExpenseRepository)
    {
        $this->model = $userExpenseRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->getAllExpense($this->model);
        return view('expense.index', ['expenses' => $response]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id)
    {
        dd("Inside userexpense create", "user_id is " . $user_id);
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
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data']]);
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
        dd("Inside userexpense edit", "user_id is " . $user_id, 'expense_id is ' . $id);
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
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data']]);
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
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

}
