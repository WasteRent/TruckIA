@extends('layouts.fleet')

@include('fleet.repair_orders.tabs', ['active_vehicle' => true])

@section('content')
	
	@include('shared.vehicles.show', ['vehicle' => $repair_order->vehicle])

	@include('fleet.vehicles.tracking', ['vehicle' => $repair_order->vehicle])

@endsection
