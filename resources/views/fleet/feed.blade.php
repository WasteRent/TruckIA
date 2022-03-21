@extends('layouts.fleet')

@section('title', __('Actividad'))

@section('content')

  @component('components.card')
    <div class="flow-root">
      <ul role="list" class="-mb-8">
        @foreach($items as $item)
        <li>
          <div class="relative pb-8">
            <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
            <div class="relative flex items-start space-x-3">
              <div class="relative">

                @if($item->user && $item->user->avatar)
                  <img loading="lazy" class="h-10 w-10 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white" src="{{ $item->user->avatar->getLink() }}"/>
                @else
                  <svg class="h-10 w-10 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                  </svg>                
                @endif

                <span class="absolute -bottom-0.5 -right-1 bg-white rounded-tl px-0.5 py-px">
                  @if(in_array($item->type, ['vehicle_created', 'vehicle_state_changed']))
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                  </svg>
                  @elseif(in_array($item->type, ['incident_closed', 'incident_opened']))
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $item->type == 'incident_opened' ? 'text-red-500':'text-green-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                  </svg>
                  @elseif(in_array($item->type, ['order_opened']))
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                  </svg>
                  @elseif(in_array($item->type, ['order_state_updated']))
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                  </svg>
                  @elseif(in_array($item->type, ['vehicle_reassigned']))
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  @endif
                </span>
              </div>
              <div class="min-w-0 flex-1">
                <div>
                  <div class="">
                    <a href="{{ $item->url }}" class="text-gray-900 text-base">{{ $item->title }}</a>
                  </div>
                  <p class="mt-0.5 text-xs text-gray-500" title="{{ $item->created_at }}">
                    <span class="font-medium">{{$item->user->name}}</span>
                    {{ $item->created_at->diffForHumans() }}
                  </p>
                </div>
                <div class="mt-2 text-sm text-gray-700">
                  <p></p>
                </div>
              </div>
            </div>
          </div>
        </li>
        @endforeach
      </ul>
    </div>
  @endcomponent

@endsection