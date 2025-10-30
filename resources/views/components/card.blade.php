<div class="rounded-xl w-full bg-white border border-gray-200 sm:mb-6 mb-4 @if(!isset($is_table) || $is_table != true) overflow-hidden @endif transition-all duration-200 hover:shadow-lg @if(!isset($no_shadow)) shadow-soft @endif">
	@if(isset($title) || isset($corner))
	<div class="flex justify-between items-center bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 py-4 px-6">
		@if(isset($title))
			<h3 class="text-lg font-bold text-gray-900">{{ $title }}</h3>
		@else 
			<div></div>	
		@endif
		
		@if(isset($corner))
			<div class="flex items-center gap-2">{{ $corner }}</div>
		@endif

		@if(isset($compressed))
			<button class="card-expand-btn p-2 rounded-lg hover:bg-gray-100 transition-colors">
				<i class="fas fa-chevron-down text-gray-600"></i>
			</button>
		@endif
	</div>
	@endif

	<div class="card-slot @if(isset($compressed)) hidden @endif @if(isset($is_table) && $is_table == true) p-0 @else py-5 px-6 @endif">
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
