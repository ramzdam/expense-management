@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        @include('partials.menu')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Expense Categories') }} <a href="{{ route('expense.category.create.form') }}" class="float-right btn btn-success">{{ __('Create Category') }}</a></div>

                <div class="card-body">
                    @if($categories)
                        <table class="table table-stripe table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        <a href="{!! route('expense.category.edit.form', ['id' => $category->p_id]) !!}" class="edit btn btn-info">Edit</a>
                                        <a href="{!! route('expense.category.delete', ['id' => $category->p_id]) !!}" class="delete-category btn btn-danger">Delete</a>
                                    </td>
                                </tr>
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