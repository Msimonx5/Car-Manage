@props(['status'])

<span class="pill {{ $status->color() }}">{{ $status->label() }}</span>
