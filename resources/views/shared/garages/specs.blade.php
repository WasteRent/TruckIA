<div>
	@if(isset($garage))
		@foreach($garage->specialities as $spec)
			@if($spec->pivot->stars > 0)
			<div class="flex items-center">
				<span class="text-xs w-16 mr-2">{{ $spec->name }}</span>
				<stars :rating="{{ $spec->pivot->stars }}"></stars>
			</div>
			@endif
		@endforeach
	@endif
</div>