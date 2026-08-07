@if(session('info'))

<div class="alert alert-info alert-dismissible fade show">

    {{ session('info') }}

    <button
        class="btn-close"
        data-bs-dismiss="alert">

    </button>

</div>

@endif