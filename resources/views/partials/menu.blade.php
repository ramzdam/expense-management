<div class="col-md-3">
    <div class="card">
        <div class="card-header">Menu</div>

        <div class="card-body">
            <ul>
                <li><a href="{{ route('home') }}">Dashboard</a></li>
                
                <li><a href="{{ route('user.home') }}">User Management</a></li>
                
                
                <li><a href="{{ route('expense.home') }}">Expense Management</a></li>
                
                @can('can-create-expense-category')
                <li><a href="{{ route('expense.category.home') }}">Expense Category</a></li>
                @endcan
            </ul>
        </div>
    </div>            
</div>