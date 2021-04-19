@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('partials.menu')
        <div class="col-md-8">
            <div class="card">                
                <div class="card-header">{{ __('Users') }} 
                    @can('can-create-user')
                    <a href="{!! route('user.create.form') !!}" class="float-right btn btn-success">{{ __('Create New User') }}</a>
                    @endcan
                </div>

                <div class="card-body">
                    @include('partials.flash-message')
                    @if(isset($users) && $users)
                        <table class="table table-stripe table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">First Name</th>                                                                        
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Action</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                @can('can-view-user', $user)
                                <tr>
                                    <td>{{ $user->name }}</td>                                    
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->userRole->role->name }}</td>
                                    <td>
                                        <a href="{!! route('user.edit.form', ['id'=> $user->p_id]) !!}" class="edit btn btn-info">Edit</a>
                                        @can('can-delete-user')
                                        <a href="{!! route('user.delete', ['id'=> $user->p_id]) !!}" class="delete-user btn btn-danger">Delete</a>
                                        @endcan
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