@props(['vehicle'])

@php $status = $vehicle->oil_change_status; @endphp

@if($status == 'danger')
    <span class="pill danger">Vidange urgente</span>
@elseif($status == 'warning')
    <span class="pill warning">Vidange bientôt</span>
@elseif($status == 'success')
    <span class="pill success">Vidange OK</span>
@else
    <span class="pill secondary">Non définie</span>
@endif
