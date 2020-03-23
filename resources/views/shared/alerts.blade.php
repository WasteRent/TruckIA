@if (session('success_message'))
	<div class="my-3">
		@component('components.alert-success')
			{{ session('success_message') }}
		@endcomponent
	</div>
@elseif(session('error_message'))
	<div class="my-3">
		@component('components.alert-error')
			{{ session('error_message') }}
		@endcomponent
	</div>
@elseif(session('warning_message'))
	<div class="my-3">
		@component('components.alert-warning')
			{{ session('warning_message') }}
		@endcomponent
	</div>
@endif

@if ($errors->any())
	<div class="my-3">
		@component('components.alert-error')
			<ul>
			    @foreach ($errors->all() as $error)
			        <li>&middot; {{ $error }}</li>
			    @endforeach
			</ul>
		@endcomponent
	</div>
@endif