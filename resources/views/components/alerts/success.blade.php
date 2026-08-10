@if(session('success'))

<div class="alert alert-success alert-dismissible fade show">

    <i class="bi bi-check-circle-fill me-2"></i>

    {{ session('success') }}

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">

    </button>

</div>

@endif