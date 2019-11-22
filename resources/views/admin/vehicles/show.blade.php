@extends('layouts.admin')

@section('content')
	
	@include('shared.vehicles.show', ['vehicle' => $vehicle])

	@include('shared.vehicles.operations', ['vehicle' => $vehicle])

@endsection
