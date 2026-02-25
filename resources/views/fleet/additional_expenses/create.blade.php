@extends('layouts.fleet')

@section('title', __('Carga de gastos'))

@section('content')

@component('components.card')
@slot('title', __('Nuevo gasto'))

{!! Form::open([
	'route' => ['fleet.additional-vehicle-expenses.store'],
	'method' => 'POST',
	'class' => 'w-full',
	'files' => true,
]) !!}

<label class="form-label">
	Archivo
</label>
{!! Form::file('file', ['class' => 'form-input']) !!}
<br>
<div class="flex gap-4">
	<div class="flex flex-col">
	<label class="form-label">
		Tipo de plantilla
	</label>
	{!! Form::select('template_type', [
		'UTE_RM_VAO' => 'UTE RM VAO',
		'VISION' => 'VISION',
		'ZONA_SUR' => 'ZONA SUR',
		'ZONA_CENTRO_GALICIA' => 'ZONA CENTRO - GALICIA',
	], null, ['class' => 'form-select', 'id' => 'templateType']) !!}
	</div>
</div>
	<div class="flex gap-4 mt-4">
		<a href="/excel/PLANTILLA_UTE.xlsx" class="btn-outline-gray template-link" style="display: none;" data-template="UTE_RM_VAO">
			Plantilla UTE RM VAO
		</a>
		<a href="/excel/Plantilla_Vision.xlsx" class="btn-outline-gray template-link" style="display: none;" data-template="VISION">
			Plantilla VISION
		</a>
		<a href="/excel/Plantilla_Zona_Sur_1.xlsx" class="btn-outline-gray template-link" style="display: none;" data-template="ZONA_SUR">
			Plantilla ZONA SUR
		</a>
		<a href="/excel/PlantillaZonaCentroGalicia.xlsx" class="btn-outline-gray template-link" style="display: none;" data-template="ZONA_CENTRO_GALICIA">
			Plantilla ZONA CENTRO - GALICIA
		</a>
	</div>
	<div class="flex justify-end  items-center mt-4">
	<button class="btn-indigo ">{{ __('Guardar') }}</button>
</div>

{!! Form::close() !!}
@endcomponent


@endsection

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const templateSelect = document.getElementById('templateType');
		const templateLinks = document.querySelectorAll('.template-link');
		function updateTemplateLinks() {
			const selectedValue = templateSelect.value;
			templateLinks.forEach(link => {
				if (link.dataset.template === selectedValue) {
					link.style.display = 'inline-block';
				} else {
					link.style.display = 'none';
				}
			});
		}
	templateSelect.addEventListener('change', updateTemplateLinks);
    updateTemplateLinks();
});
</script>