@if(Session::has('alert-success'))
<p class="alert alert-success">{{ Session::get('alert-success') }}</p>
@endif
@if(Session::has('alert-danger'))
<p class="alert alert-danger">{{ Session::get('alert-danger') }}</p>
@endif