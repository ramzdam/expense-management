@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('partials.menu')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create new Expense') }}</div>

                <div class="card-body">

                    <form method="POST" action="{!! route('user.expense.save', ['user_id' => Auth::user()->p_id]) !!}">
                        @csrf

                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}</label>

                            <div class="col-md-6">
                                <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required autocomplete="amount" autofocus>

                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="expense_type" class="col-md-4 col-form-label text-md-right">{{ __('Expense Type') }}</label>
                            @if($expense_categories)
                                <select class="form-control col-md-5" name="expense_type" id="expense_type">
                                @foreach($expense_categories as $expense_category)
                                    <option value="{{ $expense_category->p_id }}">{{ $expense_category->name }}</option>
                                @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="create-expense">
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection