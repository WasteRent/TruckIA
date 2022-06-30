<div class="sm:rounded-lg w-full rounded bg-white border-b sm:mb-3 mb-4 sm:overflow-hidden" style="@if(!isset($no_shadow)) box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%); @endif">
	@if(isset($title) || isset($corner))
	<div class="flex justify-between items-center border-b py-3 sm:py-3 px-4 sm:px-6">
		@if(isset($title))
			<div class="">{{ $title }}</div>
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

	<div class="card-slot @if(isset($compressed)) hidden @endif @if(isset($is_table) && $is_table == true) p-0 @else py-3 sm:py-4 px-4 sm:px-6 @endif">
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
