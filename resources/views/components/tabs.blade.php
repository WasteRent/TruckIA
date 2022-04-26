<div class="bg-white rounded-lg mb-4">
  <div class="sm:hidden">
    <select class="form-select block w-full border-b-2 font-medium text-blue-600" onchange="location = this.value;">
    	@foreach($items as $item)
    		<option value="{{ $item['url'] }}" @if(request()->url() == $item['url']) selected @endif>{!! $item['name'] !!}</option>
    	@endforeach
    </select>
  </div>
  <div class="hidden sm:block">
    <div class="border-b border-gray-200">
      <nav class="-mb-px flex">
      	@foreach($items as $item)
          @if(isset($item['available']) && $item['available'])
            <a href="{{ $item['url'] }}" class="flex-1 py-4 px-1 text-center border-b-2 font-medium text-sm leading-5 focus:outline-none {{ $item['active'] ? 'border-blue-500 text-blue-600 focus:text-blue-800 focus:border-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300' }}">
            {!! $item['name'] !!}
            </a>
          @elseif(!isset($item['available']))
            <a href="{{ $item['url'] }}" class="flex-1 py-4 px-1 text-center border-b-2 font-medium text-sm leading-5 focus:outline-none {{ $item['active'] ? 'border-blue-500 text-blue-600 focus:text-blue-800 focus:border-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300' }}">
            {!! $item['name'] !!}
            </a>
          @endif
        @endforeach
      </nav>
    </div>
  </div>
</div>

