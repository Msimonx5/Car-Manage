@if(session('warning'))

<div class="alert alert-warning alert-dismissible fade show">

    {{ session('warning') }}

    <button
        class="btn-close"
        data-bs-dismiss="alert">

    </button>

</div>

@endif