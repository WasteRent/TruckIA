<x-mail::message>
# Truck-I

Hola, te han asignado la OR {{ $order->id }}.

<x-mail::button :url="route('fleet.repair-orders.show', $order)">
Ver O.R.
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
