@extends('layouts.fleet')

@section('title', __('Calendario'))

@section('content')
  
  @component('components.search-card')
      {!! Form::model(request()->all(), ['method' => 'GET','class' => ['md:flex items-center']]) !!}
          <div class="lg:px-3 md:w-1/5 lg:mb-0 mb-3">
            <label class="form-label">{{ __('Mes') }}</label>
              {!! Form::select('month', collect(range(1, 12))->mapWithKeys(function($i) {
                  return [$i => Carbon\Carbon::create()->day(1)->month($i)->monthName];
                }), request()->month ?? (int)date('m'), ['class' => 'form-select']) !!}
          </div>
          <div class="lg:px-3 md:w-1/5 lg:mb-0 mb-3">
            <label class="form-label">{{ __('Año') }}</label>
            {!! Form::select('year', [date('Y') - 1 => date('Y') - 1, date('Y') => date('Y'), date('Y') + 1 => date('Y') + 1], request()->year ?? date('Y'), ['class' => 'form-select']) !!}
          </div>
          <div class="text-right">
              <button class="btn-search">
                <i class="fas fa-search"></i>
              </button>
          </div>
      {!! Form::close() !!}
  @endcomponent


  <div class="mt-6">
    <div class="flex justify-between">
      <h2 class="text-lg font-semibold text-gray-900">Próximos eventos</h2>
      <a href="{{ route('fleet.calendar.create') }}" class="btn-indigo">
        Añadir evento
      </a>
    </div>
    <div class="lg:grid lg:grid-cols-12 lg:gap-x-16">
      <ol class="mt-4 divide-y divide-gray-100 text-sm leading-6 lg:col-span-6">
        @foreach($items as $item)
          <li class="relative flex space-x-6 py-6 xl:static">
            <img loading="lazy" src="{{ $item->order->vehicle->getCover()?->getLink() }}" alt="" class="h-14 w-14 flex-none rounded-full">
            <div class="flex-auto">
              <h3 class="pr-10 font-semibold text-gray-900 xl:pr-0">{{ $item->order->vehicle->plate }} &middot; {{ $item->order->type == 'corrective' ? 'Correctivo':'Preventivo' }} programado. 
                <span class="badge {{ $item->order->state->color }}">
                  {{ __($item->order->state->name) }}
                </span>
              </h3>
              <dl class="mt-2 flex flex-col text-gray-500 xl:flex-row">
                <div class="flex items-start space-x-3">
                  <dt class="mt-0.5">
                    <span class="sr-only">Date</span>
                    <!-- Heroicon name: mini/calendar -->
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                    </svg>
                  </dt>
                  <dd><time>{{ Carbon\Carbon::parse($item->date)->isoFormat('ddd D MMMM YYYY') }}</time></dd>
                </div>
                <div class="mt-2 flex items-start space-x-3 xl:mt-0 xl:ml-3.5 xl:border-l xl:border-gray-400 xl:border-opacity-50 xl:pl-3.5">
                  <dt class="mt-0.5">
                    <span class="sr-only">Cliente</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-400">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                  </dt>
                  <dd>{{ optional($item->order->vehicle->customer)->name }}</dd>
                </div>
                <div class="mt-2 flex items-start space-x-3 xl:mt-0 xl:ml-3.5 xl:border-l xl:border-gray-400 xl:border-opacity-50 xl:pl-3.5">
                  <dt class="mt-0.5">
                    <span class="sr-only">Location</span>
                    <!-- Heroicon name: mini/map-pin -->
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                    </svg>
                  </dt>
                  <dd>{{ $item->order->garage->name }}</dd>
                </div>
              </dl>
            </div>
          </li>
        @endforeach
      </ol>

      <ol class="mt-4 divide-y divide-gray-100 text-sm leading-6 lg:col-span-6">
        @foreach($events as $event)
        <li class="relative flex space-x-6 py-6 xl:static">
          <img loading="lazy" src="{{ Auth::user()->avatar ? Auth::user()->avatar->getLink() : 'https://foundationfar.org/wp-content/uploads/2020/03/Profile_avatar_placeholder_large.png' }}" alt="" class="h-14 w-14 flex-none rounded-full">
          <div class="flex-auto">
            <h3 class="pr-10 font-semibold text-gray-900 xl:pr-0">{{ $event->title }}</h3>
            <div class="italic text-xs">{!! $event->description !!}</div>
            <dl class="mt-2 flex flex-col text-gray-500 xl:flex-row">
              <div class="flex items-start space-x-3">
                <dt class="mt-0.5">
                  <span class="sr-only">Date</span>
                  <!-- Heroicon name: mini/calendar -->
                  <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                  </svg>
                </dt>
                <dd><time datetime="2022-01-10T17:00">{{ Carbon\Carbon::parse($event->datetime)->isoFormat('ddd D MMMM YYYY HH:mm') }}</time></dd>
              </div>
            </dl>
          </div>
        </li>
        @endforeach
      </ol>
    </div>
  </div>

@endsection