@component('components.card', ['is_table' => true, 'no_shadow' => 1])
	@slot('title', __('Documentos'))

	<table>
	  <tbody>
	  	@foreach($vehicle->files as $file)
	  	<tr>
	  	  <td>
	  	  	<a class="font-medium" target="_blank" href="{{$file->getLink()}}">
	  	  		{{$file->description}}
	  	  	</a>
	  	  </td>
	  	</tr>
	  	@endforeach

	  	@foreach($vehicle->modelsRelated() as $model)
		  	@if($model->technicalHandbook)
		  	<tr>
		  	  <td>
		  	  	<a class="font-medium" target="_blank" href="{{$model->technicalHandbook->getLink()}}">
		  	  		{{ __('Manual técnico') }} {{$model->manufacturer->name}} {{$model->name}}  ({{ $model->technicalHandbook->size }})
		  	  	</a>
		  	  </td>
		  	</tr>
		  	@endif
		  	@if($model->usageHandbook)
		  	<tr>
		  	  <td>
		  	  	<a class="font-medium" target="_blank" href="{{$model->usageHandbook->getLink()}}">
		  	  		{{ __('Manual de uso') }} {{$model->manufacturer->name}} {{$model->name}} ({{ $model->usageHandbook->size }})
		  	  	</a>
		  	  </td>
		  	</tr>
		  	@endif
	  	@endforeach
	  </tbody>
	</table>
@endcomponent