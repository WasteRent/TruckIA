@extends('layouts.pdf')

@section('content')
@foreach ($container_checklists as $index => $container_checklist)
    @if($index > 0)
        <div style="page-break-after: always;"></div>
    @endif

    @include('fleet.containers.checklist.pdf_single', ['container_checklist' => $container_checklist])
@endforeach
@endsection

