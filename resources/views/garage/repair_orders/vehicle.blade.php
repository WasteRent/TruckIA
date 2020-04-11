@extends('layouts.garage')

@include('garage.repair_orders.tabs', ['active_vehicle' => true])

@section('content')
	
	@include('shared.vehicles.show', ['vehicle' => $repair_order->vehicle])

@endsection
