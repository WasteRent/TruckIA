@extends('layouts.customer')

@section('content')
	
	@include('shared.vehicles.show', ['vehicle' => $vehicle])

@endsection
