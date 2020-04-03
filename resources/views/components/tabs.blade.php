<div class="bg-white rounded overflow-hidden mb-4">
  <div class="sm:hidden">
    <select class="form-select block w-full">
    	@foreach($items as $item)
    		<option>{{ $item['name'] }}</option>
    	@endforeach
    </select>
  </div>
  <div class="hidden sm:block">
    <div class="border-b border-gray-200">
      <nav class="-mb-px flex">
      	@foreach($items as $item)
        <a href="{{ $item['url'] }}" class="flex-1 py-4 px-1 text-center border-b-2 font-medium text-sm leading-5 focus:outline-none {{ $item['active'] ? 'border-indigo-500 text-indigo-600 focus:text-indigo-800 focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300' }}">
          {{ $item['name'] }}
        </a>
        @endforeach
      </nav>
    </div>
  </div>
</div>

