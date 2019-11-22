@extends('layouts.admin')

@section('content')
	
	@include('shared.garages.show', ['garage' => $garage])

	@include('shared.garages.operations', ['garage' => $garage])

@endsection