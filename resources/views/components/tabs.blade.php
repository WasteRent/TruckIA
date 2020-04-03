<div class="flex rounded overflow-hidden">
	@foreach($items as $item)
		<div class="flex-1 text-center py-2 uppercase text-xs {{ $item['active'] ? 'tab-active' : 'tab-inactive' }}">
			<a href="{{ $item['url'] }}" class="">{{ $item['name'] }}</a>
		</div>
	@endforeach
</div>
<br>