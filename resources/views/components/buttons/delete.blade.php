<form
    action="{{ $url }}"
    method="POST"
    class="d-inline">

    @csrf

    @method('DELETE')

    <button
        onclick="return confirm('Confirmer la suppression ?')"
        class="btn btn-danger btn-sm">

        <i class="bi bi-trash"></i>

        Supprimer

    </button>

</form>