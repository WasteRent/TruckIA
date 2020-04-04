<div class="shadow rounded-lg bg-white border-b mb-3 overflow-hidden">
	@if(isset($title) || isset($corner))
	<div class="flex justify-between border-b py-4 px-6">
		@if(isset($title))
			<div class="font-medium">{{ $title }}</div>
		@else 
			<div></div>	
		@endif
		@if(isset($corner))
			<div>{{ $corner }}</div>
		@endif
	</div>
	@endif

	<div class="@if(isset($is_table) && $is_table == true) p-0 @else p-8 @endif">
		{{ $slot }}
	</div>
</div>