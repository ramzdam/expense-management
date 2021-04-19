<div class="col-md-3">
    <div class="card">
        <div class="card-header">Menu</div>

        <div class="card-body">
            <ul>
                <li><a href="{{ route('home') }}">Dashboard</a></li>
                @can('can-view-user-management')
                <li><a href="{{ route('user.home') }}">User Management</a></li>
                @endcan
                @cannot('can-view-user-management')
                <li><a href="{!! route('user.useredit.form', ['id'=> Auth::user()->p_id]) !!}">Edit Account</a></li>
                @endcannot
                <li><a href="{{ route('expense.home') }}">Expense Management</a></li>                
                @can('can-create-expense-category')
                <li><a href="{{ route('expense.category.home') }}">Expense Category</a></li>
                @endcan
            </ul>
        </div>
    </div>            
</div>