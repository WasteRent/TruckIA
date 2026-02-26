@extends('layouts.fleet')

@section('title', $container->reference .' '. $container->maker)

@section('content')

	@include('fleet.containers.edit_tabs', ['active_checklists' => true])

	@component('components.card', ['compressed' => true])
    @slot('title', __('Añadir checklist'))
    @include('fleet.containers.checklist.create')
	@endcomponent

	<br><br>

	@component('components.search-card')
	{!! 
	  Form::model(request()->all(), [
	    'route' => ['fleet.containers.checklists.index', $container], 
	    'method' => 'GET',
	    'class' => ['md:flex items-center']
	  ])
	!!}
	    <div class="lg:px-3 lg:mb-0 mb-3">
	      <label class="form-label">{{ __('Tipo') }}</label>
	      <select name="checklist_id" class="form-input">
	        <option value="">{{ __('Todos') }}</option>
	        @foreach ($checklists as $checklist)
	          <option value="{{ $checklist->id }}">{{ $checklist->name }}</option>
	        @endforeach
	      </select>
	    </div>
	    <div class="lg:px-3 lg:mb-0 mb-3">
	      <label class="form-label">{{ __('Fecha') }}</label>
	      {!! Form::date('date', request('date'), ['class' => 'form-input']) !!}
	    </div>
	    <div class="text-right">
	        <button class="btn-search">
	          <i class="fas fa-search"></i>
	        </button>
	    </div>
	{!! Form::close() !!}
	@endcomponent

	@if($containerChecklists->count() > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', __('Checklists'))
			<table>
			  <thead>
			    <tr>
			        <th class="">{{ __('Tipo') }}</th>
			        <th class="">{{ __('Fecha') }}</th>
			        <th class=""></th>
			    </tr>
			  </thead>
			  <tbody>
			    @foreach ($containerChecklists as $containerChecklist)
			      <tr>
			        <td>
			            {{$containerChecklist->checklist->name}}
			        </td>
			        <td>{{ $containerChecklist->date ? \Carbon\Carbon::parse($containerChecklist->date)->format('d/m/Y') : $containerChecklist->created_at->format('d/m/Y') }}</td>
			        <td>
			            <div class="flex items-center gap-2">
							<button type="button" class="p-1 text-gray-600 hover:text-green-600" title="{{ __('Enviar por correo') }}" onclick="openSendEmailModal('{{ route('fleet.container-checklists.send-pdf', $containerChecklist) }}')">
			                    <i class="icon fas fa-envelope"></i>
			                </button>
			                <a href="{{ route('fleet.container-checklists.edit', $containerChecklist) }}" class="mr-1" title="{{ __('Editar') }}">
			                    <i class="icon fas fa-edit"></i>
			                </a>
			                <form method="POST" class="inline" onsubmit="return confirmDelete()" action="{{ route('fleet.container-checklists.destroy', $containerChecklist) }}">
			                    @csrf
			                    @method('DELETE')
			                    <button type="submit" title="{{ __('Eliminar') }}"><i class="icon fas fa-trash-alt"></i></button>
			                </form>
			            </div>
			        </td>
			      </tr>
			    @endforeach
			  </tbody>
			</table>
		@endcomponent
	@endif

	<!-- Modal enviar checklist por correo -->
	<div id="send-email-modal" class="modal" style="display: none;">
		<form id="send-email-form" method="POST" action="">
			@csrf
			<h3 class="text-lg font-semibold mb-4">{{ __('Enviar checklist por correo') }}</h3>
			<div class="mb-4">
				<label for="send-email-to" class="form-label form-required">{{ __('Correo electrónico') }}</label>
				<input type="email" id="send-email-to" name="email" class="form-input w-full" required>
			</div>
			<div class="flex gap-3 justify-end">
				<button type="button" class="btn-outline-gray" onclick="closeSendEmailModal()">{{ __('Cancelar') }}</button>
				<button type="submit" class="btn-indigo">
					<i class="fas fa-envelope mr-2"></i>{{ __('Enviar') }}
				</button>
			</div>
		</form>
	</div>
@endsection

@push('js')
<script>
function openSendEmailModal(url) {
	document.getElementById('send-email-form').action = url;
	document.getElementById('send-email-to').value = '';
	$('#send-email-modal').modal();
}
function closeSendEmailModal() {
	$('#send-email-modal').modal('close');
}
</script>
@endpush
