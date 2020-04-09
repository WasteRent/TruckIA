@foreach($items as $name => $value)
	<div class="flex text-sm py-1">
		<div class="w-1/3 text-gray-800 font-medium">{{$name}}</div>
		<div class="w-2/3 text-gray-600">{!! $value !!}</div>
	</div>
@endforeach