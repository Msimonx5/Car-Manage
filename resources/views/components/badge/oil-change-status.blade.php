@props(['vehicle'])

@php

$status = $vehicle->oil_change_status;

@endphp

@if($status == 'danger')

<span class="badge bg-danger">

    Vidange urgente

</span>

@elseif($status == 'warning')

<span class="badge bg-warning text-dark">

    Vidange bientôt

</span>

@elseif($status == 'success')

<span class="badge bg-success">

    Vidange OK

</span>

@else

<span class="badge bg-secondary">

    Non définie

</span>

@endif