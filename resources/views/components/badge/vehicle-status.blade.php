@props(['status'])

@php

$color = $status->color();

$label = $status->label();

@endphp

<span class="badge bg-{{ $color }}">

    {{ $label }}

</span>