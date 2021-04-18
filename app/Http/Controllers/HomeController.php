<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\UserExpenseTrait;
use App\Repositories\UserExpenseRepository;

class HomeController extends Controller
{
    use UserExpenseTrait;

    public $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserExpenseRepository $userExpenseRepository)
    {
        $this->middleware('auth');
        $this->model = $userExpenseRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        return view('home');
    }

    public function chart()
    {
        $result = $this->getExpenseChart($this->model);
        return response()->json(['success' => false, 'data' => $result]);
    }
}
