@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('partials.menu')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Expenses') }} <a href="{!! route('user.expense.create.form', ['user_id' => Auth::user()->p_id ]) !!}" class="float-right btn btn-success">{{ __('Create Expense') }}</a></div>

                <div class="card-body">
                    @include('partials.flash-message')
                    @if($expenses)
                        <table class="table table-stripe table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Action</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expenses as $expense)
                                @can('view-expense',$expense)
                                <tr>
                                    <td>{{ $expense->user->name }}</td>
                                    <td>{{ $expense->amount }}</td>
                                    <td>{{ $expense->expenseCategory->name }}</td>
                                    <td>
                                        <a href="{!! route('user.expense.edit.form', ['user_id'=> $expense->user->p_id,'id' => $expense->p_id]) !!}" class="edit btn btn-info">Edit</a>
                                        <a href="{!! route('user.expense.delete', ['user_id'=> $expense->user->p_id,'id' => $expense->p_id]) !!}" class="delete-expense btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @endcan
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection