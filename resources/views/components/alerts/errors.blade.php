@if($errors->any())

<div class="alert alert-danger alert-dismissible fade show">

    <strong>

        Veuillez corriger les erreurs suivantes :

    </strong>

    <ul class="mt-2 mb-0">

        @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

    <button
        class="btn-close"
        data-bs-dismiss="alert">

    </button>

</div>

@endif