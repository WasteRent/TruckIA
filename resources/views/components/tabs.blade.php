<div class="flex">
	@foreach($items as $item)
		<div class="flex-1 text-center py-4 {{ $item['active'] ? 'tab-active' : 'tab-inactive' }}">
			<a href="{{ $item['url'] }}" class="">{{ $item['name'] }}</a>
		</div>
	@endforeach
</div>
<br>