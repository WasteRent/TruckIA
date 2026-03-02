@extends('layouts.pdf')

@section('content')
@include('fleet.containers.checklist.pdf_single', ['container_checklist' => $container_checklist])
@endsection
