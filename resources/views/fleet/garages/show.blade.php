@extends('layouts.fleet')

@section('content')
	
	@include('shared.garages.show', ['garage' => $garage])

	@include('shared.garages.repair_orders', ['garage' => $garage])

@endsection