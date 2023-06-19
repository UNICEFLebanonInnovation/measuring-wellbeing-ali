@if(Session::has('danger'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        {{ Session::get('danger') }}
    </div>
@endif
@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        {{ Session::get('success') }}
    </div>
@endif