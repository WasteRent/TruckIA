@extends('layouts.fleet')

@section('content')

    <div class="sticky top-0 hidden" id="delivery-autosave-alert">
        <div class="w-64 rounded-full bg-blue-50 p-0.5 border text-xs bg-slate-50/90 backdrop-blur-sm">
        <div class="flex">
            <div class="flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            </div>
            <div class="ml-3 flex-1 md:flex md:justify-between">
            <p class="text-blue-700">Checklist actualizada...</p>
            </div>
        </div>
        </div>
    </div>

    <div class="flex justify-end">
        @if ($vehicle_checklist->signature)
            <a class="text-red-800" href="{{ route('fleet.vehicle-checklists.pdf', $vehicle_checklist) }}">
                <i class="fas fa-print mr-1"></i> Imprimir
            </a>
        @endif
    </div>

    <br>
	
	@component('components.card')
		@slot('title', 'Checklist '.$vehicle_checklist->checklist->name.' de vehiculo con matrícula ' . $vehicle_checklist->vehicle->plate)

        {!! Form::model($vehicle_checklist, [
            'route' => ['fleet.vehicle-checklists.update', $vehicle_checklist],
            'method' => 'PUT',
            'files' => true,
            'class' => 'w-full auto_submit'
        ]) !!}  

        <input type="hidden" name="signature">

		@include('fleet.vehicles.checklist.form')

        <div>
            <label class="text-base font-medium text-gray-900">Observaciones</label>
            <x-trix class="mb-8" name="notes">
                {{ $vehicle_checklist->notes }}
            </x-trix>
        </div>

        @if ($vehicle_checklist->positions)
		    <div class="grid grid-cols-1 gap-x-4 ">
                @include('shared.grid', [
                    'grid_x' => explode('x', $vehicle_checklist->grid)[0],
                    'grid_y' => explode('x', $vehicle_checklist->grid)[1],
                    'select_positions' => $vehicle_checklist->positions,
                ])
            </div>
        @else
            <div class="grid grid-cols-1 gap-x-4 ">
                <input type="hidden" name="grid" value="{{ $grid_x }}x{{ $grid_y }}">
                <input type="hidden" name="grid-position" value="">
                @include('shared.grid', ['edit_mode' => true])
            </div>	
        @endif

        {!! Form::close() !!}

	@endcomponent

	@if(!$vehicle_checklist->signature)
    @include('sign', [
        'saveRoute' => route('fleet.vehicle-checklists.update', $vehicle_checklist),
        'redirectRoute' => route('fleet.vehicle-checklists.pdf', $vehicle_checklist)
    ])
	@endif

@endsection

@push('js')
<script type="text/javascript">
	$('.delivery-delete-file').click(function() {
		if (confirm('Estás seguro de eliminar')) {
			$.ajax({
	            url : $(this).data('url'),
	            type: "DELETE",
	            data: {
	            	picture_position: $(this).data('picture-position'),
	            	_token: $('meta[name="csrf-token"]').attr('content')
	            },
	            complete: function(xhr, status) {
	            	location.reload();
	            }
	        });
        }
	})


	addEventListener("trix-change", function(event) {
		$("#delivery-autosave-alert").show();
		let data  = $('.auto_submit').serialize()
		data['_token'] = $('meta[name="csrf-token"]').attr('content')

		$.ajax({
            url : "{{ route('fleet.vehicle-checklists.update', [$vehicle_checklist]) }}",
            type: "PUT",
            data: data,
            complete: function(xhr, status) {
            	$("#delivery-autosave-alert").delay(1000).fadeOut('slow');
            }
        });
	})


	$('.auto_submit').change(function() {
		if ($('input[name$="picture_id"]').get(0) && $('input[name$="picture_id"]').get(0).files.length > 0) {
			$(this).find('.spinner').show()
		    $(this).submit()
		} else {
			$("#delivery-autosave-alert").show();
			$.ajax({
	            url : "{{ route('fleet.vehicle-checklists.update', [$vehicle_checklist]) }}",
	            type: "PUT",
	            data: $(this).serialize(),
	            complete: function(xhr, status) {
	            	$("#delivery-autosave-alert").delay(1000).fadeOut('slow');
	            }
	        });
		}
	})
</script>
@endpush