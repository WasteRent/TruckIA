<div class="relative w-full h-full">
    <img class="object-cover w-full h-full" src="{{ asset('img/truck-perspectives.png') }}">
    <div class="absolute inset-0 opacity-50">
        <div class="grid grid-cols-24 h-full">
            @foreach(range(1, $grid_y) as $y)
                @foreach(range(1, $grid_x) as $x)
                <div data-axis-x="{{ $x }}" data-axis-y="{{ $y }}" class="@if(in_array($x.'x'.$y, $select_positions ?? [])) bg-green-web @else bg-blue-200 hover:bg-blue-400 @endif border-dashed border border-blue-400 vehicle-grid-item"></div>
                @endforeach
            @endforeach
        </div>
    </div>
</div>




@if(isset($edit_mode))
	@push('js')
	<script type="text/javascript">
		var positions = []

		$('.vehicle-grid-item').click(function() {
			$(this).toggleClass('bg-green-web')
			$(this).toggleClass('bg-blue-200 hover:bg-blue-400')

			var pos = `${$(this).data('axis-x')}x${$(this).data('axis-y')}`
			
			positions.includes(pos)
				? positions.splice(positions.indexOf(pos), 1)
				: positions.push(pos)

			$('input[name=grid-position]').val(JSON.stringify(positions))
		})
	</script>
	@endpush
@endif