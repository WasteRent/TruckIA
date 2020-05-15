@component('mail::message')
# {{ $title }}

{{ $description }}

@component('mail::panel')
{{ $vehicle->plate }} {{ $vehicle->chassis }}
@endcomponent

@if($action_url)
@component('mail::button', ['url' => url($action_url)])
	Acceso directo
@endcomponent
@endif

@endcomponent
