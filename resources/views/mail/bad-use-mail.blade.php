<x-mail::message>
# Wasterent

Hola, se ha creado una orden de reparación por mal uso del vehículo {{ $order->vehicle->plate }}.

<x-mail::button :url="route('fleet.repair-orders.show', $order)">
Ver O.R.
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
