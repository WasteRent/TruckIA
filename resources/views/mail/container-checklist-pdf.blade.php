@component('mail::message')
{{ __('Se adjunta el PDF del checklist.') }}

**{{ $container_checklist->checklist->name }}** – {{ $container_checklist->container->reference }} · {{ \Carbon\Carbon::parse($container_checklist->date)->format('d/m/Y') }}

@endcomponent
