@component('mail::message')
# {{ $title }}

{{ $description }}

@component('mail::panel')
{{ $vehicle->plate }} {{ $vehicle->chassis }}
@endcomponent

@endcomponent
