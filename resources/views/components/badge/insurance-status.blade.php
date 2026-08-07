@props(['vehicle'])

@if($vehicle->insurance_status=='danger')

<span class="badge bg-danger">

    Assurance expirée

</span>

@elseif($vehicle->insurance_status=='warning')

<span class="badge bg-warning text-dark">

    Expire bientôt

</span>

@elseif($vehicle->insurance_status=='success')

<span class="badge bg-success">

    Valide

</span>

@else

<span class="badge bg-secondary">

    Inconnue

</span>

@endif