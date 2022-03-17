@extends('layouts.fleet')

@section('title', 'Actividad')

@section('content')
  
<div class="flow-root">
  <ul role="list" class="-mb-8">
    @foreach($items as $item)
    <li>
      <div class="relative pb-8">
        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
        <div class="relative flex items-start space-x-3">
          <div>
            <img class="h-10 w-10 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white" src="https://images.unsplash.com/photo-1520785643438-5bf77931f493?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80" alt="">
          </div>
          <div class="min-w-0 flex-1">
            <div>
              <div class="">
                <a href="{{ $item->url }}" class="font-medium text-gray-900">{{ $item->title }}</a>
              </div>
              <p class="mt-0.5 text-xs text-gray-500" title="{{ $item->created_at }}">
                <strong>{{$item->user->name}}</strong>
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
@endsection