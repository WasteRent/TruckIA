@extends('layouts.fleet')

@include('fleet.repair_orders.tabs', ['active_garage' => true])

@section('content')
	
	@include('shared.garages.show', ['garage' => $repair_order->garage])

@endsection
