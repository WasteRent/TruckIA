@extends('layouts.pdf')

@section('content')

<div class="px-6">
@foreach($plans as $plan)
<br><br>
<h1 class="font-bold mt-4">{{$plan->name}}</h1>

<table class="table-auto">
  <thead>
    <tr>
      <th class="px-4 py-2"></th>
      <th class="px-4 py-2">Descripción</th>
    </tr>
  </thead>
  <tbody>
      @foreach($plan->operations as $i => $operation)
        <tr>
          <td class="border px-4 py-2">{{$i+1}}</td>
          <td class="border px-4 py-2">
            <strong>{{ $operation->name }}</strong><br>
            <p class="mt-2">{{ $operation->description }}</p>
            @if($operation->attachment)
              <br> <img class="max-w-lg" src="{{ $operation->attachment->getLink() }}">
            @endif
          </td>
        </tr>
      @endforeach
  </tbody>
</table>
@endforeach
</div>

@endsection
