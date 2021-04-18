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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->getAll($this->model);
        // dd($response);
        return view('expense.category.index', ['categories' => $response]);
        // return response()->json(['success' => true, 'data' => $response]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expense.category.form');
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
            $redirect = route("expense.category.home");
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
        $response = $this->get($this->model, $id);        
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
        $response = $this->get($this->model, $id);
        
        return view('expense.category.edit-form', ['category' => $response["data"]]);
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
            $redirect = route("expense.category.home");
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
            $redirect = route("expense.category.home");
        }
        return response()->json(['success' => $response['status'], 'message' => $response['message'], 'data' => $response['data'], 'redirect' => $redirect]);
    }
}
