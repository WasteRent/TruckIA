<div class="shadow-lg rounded bg-white mb-3">
	@if(isset($title))
	<div class="border-b py-4 px-8">
		{{ $title }}
	</div>
	@endif
	<div class="@if(isset($is_table) && $is_table == true) p-0 @else p-8 @endif">
		{{ $slot }}
	</div>
</div>