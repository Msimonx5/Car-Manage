@props(['vehicle'])

@if($vehicle->insurance_status == 'danger')
    <span class="pill danger">Assurance expirée</span>
@elseif($vehicle->insurance_status == 'warning')
    <span class="pill warning">Expire bientôt</span>
@elseif($vehicle->insurance_status == 'success')
    <span class="pill success">Valide</span>
@else
    <span class="pill secondary">Inconnue</span>
@endif
