<table class="table-auto w-full">
  <thead class="uppercase text-xs font-bold tracking-wide">
    <tr class="bg-gray-100 border-t border-b">
      <td class="px-6 py-2">Código</td>
      <td class="px-6 py-2">Descripción</td>
      <td class="px-6 py-2">Tiempo (hrs)</td>
      <td class="px-6 py-2"></td>
    </tr>
  </thead>
  <tbody>
  	@foreach($operations as $operation)
  	<tr class="border-t border-b text-gray-700">
  	  <td class="px-6 py-2">
  	  	<span class="uppercase">{{ $operation->code }}</span>
  	  	<div class="flex items-center text-xs">
  	  		<span>{{ $operation->vehicle_type }}</span>
  	  		<ion-icon class="text-gray-500" name="ios-arrow-forward"></ion-icon>
  	  		<span>{{ $operation->subfamily->family->name }}</span>
  	  		<ion-icon class="text-gray-500" name="ios-arrow-forward"></ion-icon>
  	  		<span>{{ $operation->subfamily->name }}</span>
  	  	</div>
  	  </td>
  	  <td class="px-6 py-2">
  	  	{{ $operation->name }}
  	  	<p class="text-xs text-gray-600">{{ $operation->description }}</p>
  	  </td>
  	  <td class="px-6 py-2">{{ $operation->time_in_hours }}</td>
  	  <td class="px-6 py-2">
  	  	<a href="{{ route('admin.operations.edit', $operation) }}" class="mr-2">
  	  		<ion-icon class="text-xl" name="ios-create"></ion-icon>
  	  	</a>
  	  </td>
  	</tr>
  	@endforeach
  </tbody>
</table>