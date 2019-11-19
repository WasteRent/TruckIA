@foreach($items as $name => $value)
	<div class="flex text-sm py-1">
		<div class="w-1/3 text-gray-700">{{$name}}</div>
		<div class="w-2/3 text-gray-800">{{$value}}</div>
	</div>
@endforeach