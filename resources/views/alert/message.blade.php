@if (session()->has('success'))
    <div class="alert alert-success">
            {{ session('success') }}
    </div>
@elseif( session()->has('fail') )
    <div class="alert alert-danger">
        {{ session('fail') }}

    </div>
@endif
