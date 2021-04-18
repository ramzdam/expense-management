@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('partials.menu')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @cannot('view-dashboard')
                    You are logged in!
                    @endcannot
                    @can('view-dashboard')
                    <div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
