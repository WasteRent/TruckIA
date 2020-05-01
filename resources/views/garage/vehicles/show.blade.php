@extends('layouts.garage')

@section('content')
	
	@include('shared.vehicles.show', ['vehicle' => $vehicle])

@endsection
