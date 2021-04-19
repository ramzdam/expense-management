<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ExpenseCategoryRepository;
use App\Traits\ExpenseCategoryTrait;

class ExpenseCategory extends Controller
{
    use ExpenseCategoryTrait;
    public $model;

    public function __construct(ExpenseCategoryRepository $expenseCategoryRepository)
    {
        $this->model = $expenseCategoryRepository;
    }
    /**
     * Display a listing of the resource. Via HTML VIEW
     *
     * @return view
     */
    public function index()
    {
        $response = $this->getAll($this->model);
        return view('expense.category.index', ['categories' => $response]);
    }

    /**
     * Show the form for creating a new expense category resource.
     *
     * @return view
     */
    public function create()
    {
        return view('expense.category.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function store(Request $request)
    {
        $response = $this->save($this->model, $request);

        if ($response['status']) {
            $redirect = route("expense.category.home");
        }
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data'], 'redirect' => $redirect]);
    }

    /**
     * Display the specified expense category.
     *
     * @param  int  $id - Expense Category p_id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->get($this->model, $id);        
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data']]);
    }

    /**
     * Show the form for editing the specified expense category.
     *
     * @param  int  $id - Expense Category p_id
     * @return view
     */
    public function edit($id)
    {
        $response = $this->get($this->model, $id);
        
        return view('expense.category.edit-form', ['category' => $response["data"]]);
    }

    /**
     * Update the specified expense category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id - Expense Category p_id
     * @return Json
     */
    public function update(Request $request, $id)
    {
        $response = $this->updateRecord($this->model, $request, $id);

        if ($response['status']) {
            $redirect = route("expense.category.home");
        }
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data'], 'redirect' => $redirect]);
    }

    /**
     * Remove the specified expense category from storage.
     *
     * @param  int  $id - Expense Category p_id
     * @return Json
     */
    public function destroy($id)
    {
        $response = $this->deleteRecord($this->model, $id);

        if ($response['status']) {
            $redirect = route("expense.category.home");
        }
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data'], 'redirect' => $redirect]);
    }
}
