<div class="btn-group">

    <a
        href="{{ route('contracts.preview',$contract) }}"
        class="btn btn-secondary">

        Prévisualiser

    </a>

    <a
        href="{{ route('contracts.pdf',$contract) }}"
        target="_blank"
        class="btn btn-danger">

        Ouvrir PDF

    </a>

    <a
        href="{{ route('contracts.download',$contract) }}"
        class="btn btn-success">

        Télécharger

    </a>

</div>