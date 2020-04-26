<div class="shadow rounded-lg bg-white border-b mb-3 overflow-hidden">
	@if(isset($title) || isset($corner))
	<div class="flex justify-between items-center border-b py-4 px-6">
		@if(isset($title))
			<div class="font-bold">{{ $title }}</div>
		@else 
			<div></div>	
		@endif
		
		@if(isset($corner))
			<div>{{ $corner }}</div>
		@endif

		@if(isset($compressed))
			<button class="card-expand-btn"><i class="fas fa-chevron-down"></i></button>
		@endif

	</div>
	@endif

	<div class="card-slot @if(isset($compressed)) hidden @endif @if(isset($is_table) && $is_table == true) p-0 @else p-8 @endif">
		{{ $slot }}
	</div>
</div>

@if(isset($compressed))
	@push('js')
	    <script type="text/javascript">
	    	$(".card-expand-btn").click(function() {
	    		$(".card-slot").show('slow')
	    	})
	    </script>
	@endpush
@endif
