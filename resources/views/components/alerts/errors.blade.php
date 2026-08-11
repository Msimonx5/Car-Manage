@if($errors->any())
    <div class="flash err">
        <strong><i class="bi bi-exclamation-triangle me-1"></i>Veuillez corriger les erreurs suivantes :</strong>
        <ul class="mt-1 mb-0" style="padding-left:20px">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
